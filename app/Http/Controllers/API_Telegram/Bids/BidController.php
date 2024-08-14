<?php

namespace App\Http\Controllers\API_Telegram\Bids;

use App\Contracts\API_Telegram\Bid\BidContract;
use App\DTO\API_Telegram\Bid\DeleteBidDTO;
use App\DTO\API_Telegram\Bid\IndexDTO;
use App\DTO\API_Telegram\Bid\Payment\AskBidDTO;
use App\DTO\API_Telegram\Bid\Payment\CompleteBidDTO;
use App\DTO\API_Telegram\Bid\Payment\PayBidDTO;
use App\DTO\API_Telegram\Bid\Payment\ResponseBidDTO;
use App\DTO\API_Telegram\Bid\ShowBidDTO;
use App\DTO\API_Telegram\Bid\ShowUserBidsDTO;
use App\DTO\API_Telegram\Bid\StoreDTO;
use App\Exceptions\API_Telegram\Bid\AskBidException;
use App\Exceptions\API_Telegram\Bid\CompleteBidException;
use App\Exceptions\API_Telegram\Bid\DeleteBidException;
use App\Exceptions\API_Telegram\Bid\IndexBidsException;
use App\Exceptions\API_Telegram\Bid\PayBidException;
use App\Exceptions\API_Telegram\Bid\ResponseBidException;
use App\Exceptions\API_Telegram\Bid\StoreBidException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Bid\DeleteBidRequest;
use App\Http\Requests\API_Telegram\Bid\IndexRequest;
use App\Http\Requests\API_Telegram\Bid\Payment\AskBidRequest;
use App\Http\Requests\API_Telegram\Bid\Payment\CompleteBidRequest;
use App\Http\Requests\API_Telegram\Bid\Payment\PayBidRequest;
use App\Http\Requests\API_Telegram\Bid\Payment\ResponseBidRequest;
use App\Http\Requests\API_Telegram\Bid\ShowBidRequest;
use App\Http\Requests\API_Telegram\Bid\ShowUserBidsRequest;
use App\Http\Requests\API_Telegram\Bid\StoreRequest;
use App\Http\Resources\API_Telegram\BidResource;
use App\Http\Resources\API_Telegram\UserResource;
use Illuminate\Http\JsonResponse;
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

    public function responseBid(ResponseBidRequest $request): JsonResponse
    {
        $data = new ResponseBidDTO($request->validated());

        try {
            $this->service->responseBid($data);
        } catch (ResponseBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully responded'], 200);
    }

    public function payBid(PayBidRequest $request): JsonResponse
    {
        $data = new PayBidDTO($request->validated());

        try {
            $this->service->payBid($data);
        } catch (PayBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully paid'], 200);
    }


    public function completeBid(CompleteBidRequest $request): JsonResponse
    {
        $data = new CompleteBidDTO($request->validated());

        try {
            $this->service->completeBid($data);
        } catch (CompleteBidException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully completed'], 200);
    }


    public function showBid(ShowBidRequest $request): BidResource|JsonResponse
    {
        $data = new ShowBidDTO($request->validated());

        try {
            $bid = $this->service->showBid($data);
        } catch (IndexBidsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return new BidResource($bid);
    }
}
