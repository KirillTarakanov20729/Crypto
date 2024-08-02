<?php

namespace App\Services\API_Client\Bid;

use App\Contracts\API_Client\Bid\BidContract;
use App\DTO\API_Client\Bid\IndexDTO;
use App\DTO\API_Client\Bid\StoreDTO;
use App\DTO\API_Client\Bid\UpdateDTO;
use App\Exceptions\API_Client\Bid\DeleteBidException;
use App\Exceptions\API_Client\Bid\FindBidException;
use App\Exceptions\API_Client\Bid\IndexBidsException;
use App\Exceptions\API_Client\Bid\StoreBidException;
use App\Exceptions\API_Client\Bid\UpdateBidException;
use App\Exceptions\API_Client\user\FindUserException;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BidService implements BidContract
{

    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Bid::query()->with(['user', 'coin', 'currency'])->paginate(10, ['*'], 'page', $data->page);
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
            $bid = new Bid();
            $bid->user_id = $user->id;
            $bid->coin_id = $data->coin_id;
            $bid->currency_id = $data->currency_id;
            $bid->price = $data->price;
            $bid->amount = $data->amount;
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreBidException('Something went wrong', 500);
        }

        return true;
    }

    public function update(UpdateDTO $data): bool
    {
        try {
            /** @var Bid $bid */
            $bid = Bid::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindBidException('Bid not found', 404);
        }

        try {
            /** @var User $user */
            $user = User::query()->where('telegram_id', $data->user_telegram_id)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindUserException('User not found', 404);
        }

        try {
            $bid->user_id = $user->id;
            $bid->coin_id = $data->coin_id;
            $bid->currency_id = $data->currency_id;
            $bid->price = $data->price;
            $bid->amount = $data->amount;
            $bid->status = $data->status;
            $bid->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new UpdateBidException('Something went wrong', 500);
        }

        return true;
    }

    public function delete(int $id): bool
    {
        try {
            $bid = Bid::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindBidException('Bid not found', 404);
        }

        try {
            $bid->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteBidException('Something went wrong', 500);
        }

        return true;
    }

    public function show(int $id): Model
    {
        try {
            return Bid::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindBidException('Bid not found', 404);
        }
    }
}
