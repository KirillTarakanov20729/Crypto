<?php

namespace App\Contracts\API_Client\Coin;

use App\DTO\API_Client\Coin\IndexDTO;
use App\DTO\API_Client\Coin\StoreDTO;
use App\DTO\API_Client\Coin\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface CoinContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;
    public function store(StoreDTO $data): bool;
    public function update(UpdateDTO $data): bool;
    public function delete(int $id): bool;

    public function show(int $id): Model;
}
