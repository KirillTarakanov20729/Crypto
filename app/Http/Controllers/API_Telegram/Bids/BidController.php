<?php

namespace App\Http\Controllers\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Bid\IndexRequest;
use App\Http\Resources\API_Telegram\BidResource;
use App\Http\Resources\API_Telegram\IndexBidsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BidController extends Controller
{
    private BidContract $service;

    public function __construct(BidContract $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexDTO($request->validated());

        try {
            $bids = $this->service->index($data);
        } catch (IndexBidsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return BidResource::collection($bids);
    }
}
