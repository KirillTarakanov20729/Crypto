<?php

namespace App\Contracts\API_Telegram\Bid;

use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BidContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;
}
