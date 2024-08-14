<?php

namespace App\Contracts\API_Telegram\Bid;

use App\DTO\API_Telegram\Bid\DeleteBidDTO;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\Payment\AskBidDTO;
use App\DTO\API_Telegram\Bid\Payment\CompleteBidDTO;
use App\DTO\API_Telegram\Bid\Payment\PayBidDTO;
use App\DTO\API_Telegram\Bid\Payment\ResponseBidDTO;
use App\DTO\API_Telegram\Bid\ShowBidDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Models\Bid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BidContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;

    public function showUserBids(ShowUserBidsDTO $data): LengthAwarePaginator;

    public function delete(DeleteBidDTO $data): bool;

    public function askBid(AskBidDTO $data): Collection;

    public function responseBid(ResponseBidDTO $data): bool;

    public function payBid(PayBidDTO $data): bool;

    public function showBid(ShowBidDTO $data): Bid;
}
