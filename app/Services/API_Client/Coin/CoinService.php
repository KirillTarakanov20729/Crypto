<?php

namespace App\Services\API_Client\Coin;

use App\Contracts\API_Client\Coin\CoinContract;
use App\DTO\API_Client\Coin\IndexDTO;
use App\DTO\API_Client\Coin\StoreDTO;
use App\DTO\API_Client\Coin\UpdateDTO;
use App\Exceptions\API_Client\Coin\AllCoinsException;
use App\Exceptions\API_Client\Coin\DeleteCoinException;
use App\Exceptions\API_Client\Coin\FindCoinException;
use App\Exceptions\API_Client\Coin\IndexCoinsException;
use App\Exceptions\API_Client\Coin\StoreCoinException;
use App\Http\Filters\CoinFilter;
use App\Models\Coin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinContract
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        $filter = app()->make(CoinFilter::class, ['queryParams' => $data->except('page')->toArray()]);

        try {
            return Coin::filter($filter)->paginate(10, ['*'], 'page', $data->page);
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

            Cache::forget('coins');
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

            Cache::forget('coins');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreCoinException('Something went wrong', 500);
        }

        return true;
    }

    public function delete(int $id): bool
    {
        try {
            $coin = Coin::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCoinException('Coin not found', 404);
        }

        try {
            $coin->delete();

            Cache::forget('coins');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteCoinException('Something went wrong', 500);
        }

        return true;
    }

    public function show(int $id): Model
    {
        try {
            return Coin::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCoinException('Coin not found', 404);
        }
    }

    public function all(): Collection
    {
        try {
            return Cache::remember('coins', 3600, function () {
                return Coin::query()->orderBy('symbol', 'asc')->get();
            });

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new AllCoinsException('Something went wrong', 500);
        }
    }
}
