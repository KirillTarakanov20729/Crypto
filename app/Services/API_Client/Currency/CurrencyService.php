<?php

namespace App\Services\API_Client\Currency;

use App\Contracts\API_Client\Currency\CurrencyContract;
use App\DTO\API_Client\Currency\IndexDTO;
use App\DTO\API_Client\Currency\StoreDTO;
use App\DTO\API_Client\Currency\UpdateDTO;
use App\Exceptions\API_Client\Currency\AllCurrenciesException;
use App\Exceptions\API_Client\Currency\DeleteCurrencyException;
use App\Exceptions\API_Client\Currency\FindCurrencyException;
use App\Exceptions\API_Client\Currency\IndexCurrenciesException;
use App\Exceptions\API_Client\Currency\StoreCurrencyException;
use App\Exceptions\API_Client\Currency\UpdateCurrencyException;
use App\Models\Currency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyService implements CurrencyContract
{

    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Currency::query()->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexCurrenciesException('Something went wrong', 500);
        }
    }

    public function store(StoreDTO $data): bool
    {
        try {
            $currency = new Currency;
            $currency->name = $data->name;
            $currency->symbol = $data->symbol;
            $currency->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreCurrencyException('Something went wrong', 500);
        }

        return true;
    }

    public function update(UpdateDTO $data): bool
    {
        try {
            /** @var Currency $currency */
            $currency = Currency::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCurrencyException('Currency not found', 404);
        }

        try {
            $currency->name   = $data->name;
            $currency->symbol = $data->symbol;
            $currency->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new UpdateCurrencyException('Something went wrong', 500);
        }

        return true;
    }

    public function delete(int $id): bool
    {
        try {
            $currency = Currency::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCurrencyException('Currency not found', 404);
        }

        try {
            $currency->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteCurrencyException('Something went wrong', 500);
        }

        return true;
    }

    public function show(int $id): Model
    {
        try {
            return Currency::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindCurrencyException('Currency not found', 404);
        }
    }

    public function all(): Collection
    {
        try {
           return  Cache::remember('currencies', 3600, function () {
                return Currency::query()->orderBy('symbol', 'asc')->get();
            });
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            throw new AllCurrenciesException('Something went wrong', 500);
        }
    }
}
