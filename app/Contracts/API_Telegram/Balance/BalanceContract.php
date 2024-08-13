<?php

namespace App\Contracts\API_Telegram\Balance;

use App\DTO\API_Telegram\Balance\UpdateBalanceDTO;
use Illuminate\Database\Eloquent\Collection;

interface BalanceContract
{
    public function get_wallets(int $telegram_id): Collection;

    public function update_balance(UpdateBalanceDTO $data): bool;
}
