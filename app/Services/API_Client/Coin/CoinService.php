<?php

namespace App\Services\API_Client\Coin;

use App\Contracts\API_Client\Coin\CoinContract;
use App\DTO\API_Client\Coins\DeleteDTO;
use App\DTO\API_Client\Coins\IndexDTO;
use App\DTO\API_Client\Coins\StoreDTO;
use App\DTO\API_Client\Coins\UpdateDTO;
use App\Exceptions\API_Client\Coin\DeleteCoinException;
use App\Exceptions\API_Client\Coin\FindCoinException;
use App\Exceptions\API_Client\Coin\IndexCoinsException;
use App\Exceptions\API_Client\Coin\StoreCoinException;
use App\Models\Coin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinContract
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Coin::query()->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexCoinsException('Something went wrong', 500);
        }
    }

    public function store(StoreDTO $data): bool
    {
        try {
            $coin = new Coin();
            $coin->name = $data->name;
            $coin->symbol = $data->symbol;
            $coin->price = $data->price;
            $coin->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreCoinException('Something went wrong', 500);
        }

        return true;
    }

    public function update(UpdateDTO $data): bool
    {
        try {
            /** @var Coin $coin */
            $coin = Coin::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCoinException('Coin not found', 404);
        }

        try {
            $coin->name   = $data->name;
            $coin->symbol = $data->symbol;
            $coin->price  = $data->price;
            $coin->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreCoinException('Something went wrong', 500);
        }

        return true;
    }

    public function delete(DeleteDTO $data): bool
    {
        try {
            $coin = Coin::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCoinException('Coin not found', 404);
        }

        try {
            $coin->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteCoinException('Something went wrong', 500);
        }

        return true;
    }
}
