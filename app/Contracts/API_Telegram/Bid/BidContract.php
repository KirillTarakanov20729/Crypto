<?php

namespace App\Contracts\API_Telegram\Bid;

use App\DTO\API_Telegram\Bid\IndexDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface BidContract
{
    public function index(IndexDTO $data): Collection;
}
