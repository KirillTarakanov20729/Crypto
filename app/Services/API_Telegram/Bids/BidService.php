<?php

namespace App\Services\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Exceptions\API_Telegram\Bid\StoreBidException;
use App\Exceptions\API_Telegram\User\FindUserException;
use App\Http\Filters\BidFilter;
use App\Models\Bid;
use App\Models\Coin;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
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
}
