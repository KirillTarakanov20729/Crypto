<?php

namespace App\Services\API_Client\Coin;

use App\DTO\API_Client\Coins\IndexDTO;
use App\Models\Coin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CoinService
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        return Coin::query()->paginate(10, ['*'], 'page', $data->page);
    }
}
