<?php

namespace App\Contracts\API_Telegram\Coin;

use Illuminate\Database\Eloquent\Collection;

interface CoinContract
{
    public function all(): Collection;
}
