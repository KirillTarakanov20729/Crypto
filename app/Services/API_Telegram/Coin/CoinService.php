<?php

namespace App\Services\API_Telegram\Coin;

use App\Contracts\API_Telegram\Coin\CoinContract;
use App\Exceptions\API_Client\Coin\AllCoinsException;
use App\Models\Coin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoinService implements CoinContract
{
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
