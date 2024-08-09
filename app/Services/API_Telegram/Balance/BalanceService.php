<?php

namespace App\Services\API_Telegram\Balance;

use App\Contracts\API_Telegram\Balance\BalanceContract;
use App\Exceptions\API_Telegram\Balance\FindUserException;
use App\Exceptions\API_Telegram\Balance\GetWalletsException;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class BalanceService implements BalanceContract
{
    public function get_wallets(int $telegram_id): Collection
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $telegram_id)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        try {
            /** @var Collection $wallets */
            $wallets = $user->wallets;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new GetWalletsException('Get wallets error', 500);
        }

        return $wallets;
    }
}
