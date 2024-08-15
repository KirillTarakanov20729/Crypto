<?php

namespace App\Services\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\DeleteBidDTO;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\Payment\AskBidDTO;
use App\DTO\API_Telegram\Bid\Payment\CancelBidDTO;
use App\DTO\API_Telegram\Bid\Payment\PayBidDTO;
use App\DTO\API_Telegram\Bid\Payment\ResponseBidDTO;
use App\DTO\API_Telegram\Bid\ShowBidDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
use App\Exceptions\API_Telegram\Bid\AskBidException;
use App\Exceptions\API_Telegram\Bid\CancelBidException;
use App\Exceptions\API_Telegram\Bid\DeleteBidException;
use App\Exceptions\API_Telegram\Bid\FindBidException;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Exceptions\API_Telegram\Bid\PayBidException;
use App\Exceptions\API_Telegram\Bid\ResponseBidException;
use App\Exceptions\API_Telegram\Bid\ShowBidException;
use App\Exceptions\API_Telegram\Bid\StoreBidException;
use App\Exceptions\API_Telegram\User\FindUserException;
use App\Http\Resources\API_Telegram\PaymentResource;
use App\Http\Resources\API_Telegram\UserResource;
use App\Models\Bid;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BidService implements BidContract
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Bid::query()->whereHas('user', function ($query) use ($data) {
                $query->where('telegram_id', '!=',$data->user_telegram_id);
            })
                ->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexBidsException('Something went wrong', 500);
        }
    }

    public function store(StoreDTO $data): bool
    {
        try {
            /** @var User $user */
            $user = User::query()->where('telegram_id', $data->user_telegram_id)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindUserException('User not found', 404);
        }

        try {
            /** @var Coin $coin */
            $coin = Coin::query()->where('symbol', $data->coin_symbol)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreBidException('Coin not found', 404);
        }

        try {
            /** @var Currency $currency */
            $currency = Currency::query()->where('symbol', $data->currency_symbol)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreBidException('Currency not found', 404);
        }

        try {
            $bid = new Bid();
            $bid->uuid = uuid_create();
            $bid->user_id = $user->id;
            $bid->coin_id = $coin->id;
            $bid->currency_id = $currency->id;
            $bid->price = $data->price;
            $bid->amount = $data->amount;
            $bid->type = $data->type;
            $bid->payment_method = $data->payment_method;
            $bid->number = $data->number;
            $bid->save();

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreBidException('Something went wrong', 500);
        }

        return true;
    }

    public function showUserBids(ShowUserBidsDTO $data): LengthAwarePaginator
    {
        try {
            return Bid::query()->whereHas('user', function ($query) use ($data) {
                $query->where('telegram_id', $data->user_telegram_id);
            })
                ->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexBidsException('Something went wrong', 500);
        }
    }

    public function delete(DeleteBidDTO $data): bool
    {
        $bid = Bid::query()->where('uuid', $data->uuid)->first();

        if ($bid->user->telegram_id != $data->user_telegram_id) {
            throw new DeleteBidException('You are not allowed to delete this bid', 403);
        }

        try {
            $bid->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteBidException('Something went wrong', 500);
        }

        return true;
    }

    public function askBid(AskBidDTO $data): Collection
    {
        /** @var Bid $bid */
        $bid = Bid::query()->where('uuid', $data->uuid)->first();

        if ($bid->status != BidStatusEnum::CREATED) {
            throw new AskBidException('Bid already asked', 404);
        }

        if ($bid->user->telegram_id == $data->user_telegram_id) {
            throw new AskBidException('You are not allowed to ask for this bid', 403);
        }

        $user_ask = null;
        $user_response = null;
        $payment = null;

        DB::transaction(function() use ($bid, $data, &$user_ask, &$user_response, &$payment) {
            $bid->status = BidStatusEnum::ASKED;

            try {
                $bid->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw new AskBidException('Something went wrong', 500);
            }

            /** @var User $user_ask */
            $user_ask = User::query()->where('telegram_id', $data->user_telegram_id)->first();
            /** @var User $user_response */
            $user_response = User::query()->where('telegram_id', $bid->user->telegram_id)->first();

            $payment = new Payment;

            $payment->uuid = uuid_create();
            $payment->request_user_telegram_id = $user_ask->telegram_id;
            $payment->response_user_telegram_id = $user_response->telegram_id;
            $payment->uuid_bid = $bid->uuid;
            $payment->save();

        });

        return new Collection([
            'ask_user' => new UserResource($user_ask),
            'response_user' => new UserResource($user_response),
            'payment' => new PaymentResource($payment),
        ]);
    }

    public function responseBid(ResponseBidDTO $data): bool
    {
        /** @var Bid $bid */
        $bid = Bid::query()->where('uuid', $data->uuid)->first();

        if ($bid->status != BidStatusEnum::ASKED) {
            throw new ResponseBidException('Bid dont allowed to be answered', 404);
        }

        if ($bid->user->telegram_id != $data->user_telegram_id) {
            throw new ResponseBidException('You are not allowed to answer this bid', 403);
        }

        $bid->status = BidStatusEnum::RESPONSE;

        try {
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new ResponseBidException('Something went wrong', 500);
        }

        return true;
    }

    public function payBid(PayBidDTO $data): bool
    {
        /** @var Payment $payment */
        $payment = Payment::query()->where('uuid', $data->uuid)->first();

        /** @var Bid $bid */
        $bid = Bid::query()->where('uuid', $payment->uuid_bid)->first();

        if ($bid->status != BidStatusEnum::RESPONSE) {
            throw new PayBidException('Bid dont allowed to be paid', 404);
        }

        if ($bid->type == BidTypeEnum::BUY && $payment->response_user_telegram_id != $data->user_telegram_id) {
            throw new PayBidException('You are not allowed to pay this bid', 403);
        }

        if ($bid->type == BidTypeEnum::SELL && $payment->request_user_telegram_id != $data->user_telegram_id) {
            throw new PayBidException('You are not allowed to pay this bid', 403);
        }

        $bid->status = BidStatusEnum::PAID;

        try {
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new PayBidException('Something went wrong', 500);
        }

        return true;
    }

    public function cancelBid(CancelBidDTO $data): bool
    {
        /** @var Payment $payment */
        $payment = Payment::query()->where('uuid', $data->uuid)->first();

        try {
            /** @var Bid $bid */
            $bid = Bid::query()->where('uuid', $payment->uuid_bid)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindBidException('Bid not found', 404);
        }

        if ($data->user_telegram_id != $payment->request_user_telegram_id && $data->user_telegram_id != $payment->response_user_telegram_id) {
            throw new CancelBidException('You are not allowed to cancel this bid', 403);
        }

        if ($bid->status == BidStatusEnum::CREATED || $bid->status == BidStatusEnum::PAID) {
            throw new CancelBidException('Bid dont allowed to be canceled', 404);
        }

        try {
            $bid->status = BidStatusEnum::CREATED;
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new CancelBidException('Something went wrong', 500);
        }

        return true;
    }

    public function showBid(ShowBidDTO $data): Bid
    {
        try {
            /** @var Bid $bid */
            $bid = Bid::query()->where('uuid', $data->uuid)->firstOrFail();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new ShowBidException('Bid not found', 404);
        }

        return $bid;
    }
}
