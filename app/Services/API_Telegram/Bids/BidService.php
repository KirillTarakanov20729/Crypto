<?php

namespace App\Services\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Http\Filters\BidFilter;
use App\Models\Bid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BidService implements BidContract
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        $filter = app()->make(BidFilter::class, ['queryParams' => $data->except('page')->toArray()]);

        try {
            return Bid::filter($filter)->with(['user', 'coin', 'currency'])->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexBidsException('Something went wrong', 500);
        }
    }
}
