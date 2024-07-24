<?php

namespace App\Services\API_Client\Coin;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Collection;

class CoinService
{
    public function index(): Collection
    {
        return Coin::all();
    }
}
