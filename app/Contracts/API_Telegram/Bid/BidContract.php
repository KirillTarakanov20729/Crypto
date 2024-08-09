<?php

namespace App\Contracts\API_Telegram\Bid;

use App\DTO\API_Telegram\Bid\IndexDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BidContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;
}
