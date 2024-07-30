<?php

namespace App\Http\Controllers\API_Client\Bid;

use App\Contracts\API_Client\Bid\BidContract;
use App\DTO\API_Client\Bid\IndexDTO;
use App\DTO\API_Client\Bid\StoreDTO;
use App\DTO\API_Client\Bid\UpdateDTO;
use App\Exceptions\API_Client\Bid\DeleteBidException;
use App\Exceptions\API_Client\Bid\FindBidException;
use App\Exceptions\API_Client\Bid\IndexBidsException;
use App\Exceptions\API_Client\Bid\StoreBidException;
use App\Exceptions\API_Client\Bid\UpdateBidException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Bid\IndexRequest;
use App\Http\Requests\API_Client\Bid\StoreRequest;
use App\Http\Requests\API_Client\Bid\UpdateRequest;
use App\Http\Resources\API_Client\BidResource;
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

    public function show(int $id): JsonResponse|BidResource
    {
        try {
            $bid = $this->service->show($id);
        } catch (FindBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return new BidResource($bid);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (FindBidException|DeleteBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = new UpdateDTO($request->validated());

        try {
            $this->service->update($data);
        } catch (UpdateBidException|FindBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
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



}
