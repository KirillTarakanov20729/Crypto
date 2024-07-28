<?php

namespace App\Contracts\API_Client\Coin;

use App\DTO\API_Client\Coins\DeleteDTO;
use App\DTO\API_Client\Coins\IndexDTO;
use App\DTO\API_Client\Coins\StoreDTO;
use App\DTO\API_Client\Coins\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CoinContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;
    public function store(StoreDTO $data): bool;
    public function update(UpdateDTO $data): bool;
    public function delete(DeleteDTO $data): bool;
}
