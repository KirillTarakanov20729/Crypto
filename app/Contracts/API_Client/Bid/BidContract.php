<?php

namespace App\Contracts\API_Client\Bid;

use App\DTO\API_Client\Bid\IndexDTO;
use App\DTO\API_Client\Bid\StoreDTO;
use App\DTO\API_Client\Bid\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface BidContract
{

    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;

    public function update(UpdateDTO $data): bool;

    public function delete(int $id): bool;

    public function show(int $id): Model;
}
