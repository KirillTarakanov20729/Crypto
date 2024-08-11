<?php

namespace App\Http\Controllers\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\AskBidDTO;
use App\DTO\API_Telegram\Bid\DeleteBidDTO;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Exceptions\API_Telegram\Bid\AskBidException;
use App\Exceptions\API_Telegram\Bid\DeleteBidException;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Exceptions\API_Telegram\Bid\StoreBidException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Bid\AskBidRequest;
use App\Http\Requests\API_Telegram\Bid\DeleteBidRequest;
use App\Http\Requests\API_Telegram\Bid\IndexRequest;
use App\Http\Requests\API_Telegram\Bid\ShowUserBidsRequest;
use App\Http\Requests\API_Telegram\Bid\StoreRequest;
use App\Http\Resources\API_Telegram\BidResource;
use App\Http\Resources\API_Telegram\UserResource;
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

    public function store(StoreRequest $request): JsonResponse
    {
        $data = new StoreDTO($request->validated());

        try {
            $this->service->store($data);
        } catch (StoreBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully created'], 201);
    }

    public function showUserBids(ShowUserBidsRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new ShowUserBidsDTO($request->validated());

        try {
            $bids = $this->service->showUserBids($data);
        } catch (IndexBidsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return BidResource::collection($bids);
    }

    public function delete(DeleteBidRequest $request): JsonResponse
    {
        $data = new DeleteBidDTO($request->validated());

        try {
            $this->service->delete($data);
        } catch (DeleteBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function askBid(AskBidRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $data = new AskBidDTO($request->validated());

        try {
            $users = $this->service->askBid($data);
        } catch (AskBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return UserResource::collection($users);
    }
}
