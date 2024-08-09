<?php

namespace App\Contracts\API_Telegram\Balance;

use Illuminate\Database\Eloquent\Collection;

interface BalanceContract
{
    public function get_wallets(int $telegram_id): Collection;
}
