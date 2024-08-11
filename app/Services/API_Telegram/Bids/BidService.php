<?php

namespace App\Services\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\AskBidDTO;
use App\DTO\API_Telegram\Bid\DeleteBidDTO;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Exceptions\API_Telegram\Bid\AskBidException;
use App\Exceptions\API_Telegram\Bid\DeleteBidException;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Exceptions\API_Telegram\Bid\StoreBidException;
use App\Exceptions\API_Telegram\User\FindUserException;
use App\Http\Resources\API_Telegram\UserResource;
use App\Models\Bid;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
            throw new AskBidException('Bid already answered', 404);
        }

        if ($bid->user->telegram_id == $data->user_telegram_id) {
            throw new AskBidException('You are not allowed to ask for this bid', 403);
        }

        $bid->status = BidStatusEnum::ASKED;

        try {
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new AskBidException('Something went wrong', 500);
        }

        $user_ask = User::query()->where('telegram_id', $data->user_telegram_id)->first();
        $user_response = User::query()->where('telegram_id', $bid->user->telegram_id)->first();

        return new Collection([
            'ask_user' => new UserResource($user_ask),
            'response_user' => new UserResource($user_response),
        ]);
    }
}
