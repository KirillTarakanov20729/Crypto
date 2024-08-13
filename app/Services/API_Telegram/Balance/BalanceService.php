<?php

namespace App\Services\API_Telegram\Balance;

use App\Contracts\API_Telegram\Balance\BalanceContract;
use App\DTO\API_Telegram\Balance\UpdateBalanceDTO;
use App\Exceptions\API_Telegram\Balance\FindUserException;
use App\Exceptions\API_Telegram\Balance\GetWalletsException;
use App\Exceptions\API_Telegram\Balance\UpdateBalanceException;
use App\Models\User;
use App\Models\Wallet;
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


    public function update_balance(UpdateBalanceDTO $data): bool
    {
        /** @var User $user */
        $user = User::query()->where('telegram_id', $data->user_telegram_id)->first();

        if (!$user) {
            throw new FindUserException('User not found', 404);
        }

        try {
            $wallet = Wallet::query()->where('user_id', $user->id)
                ->whereHas('coin', function ($q) use ($data) {
                    $q->where('symbol', $data->coin_symbol);
                });

            if ($data->type == 'add') {
                $wallet->increment('balance', $data->amount);
            } elseif ($data->type == 'sub') {
                $wallet->decrement('balance', $data->amount);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new UpdateBalanceException('Update balance error', 500);
        }

        return true;
    }
}
