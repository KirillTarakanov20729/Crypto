<?php

namespace App\Http\Controllers\API_Client\Coin;

use App\DTO\API_Client\Coins\DeleteDTO;
use App\DTO\API_Client\Coins\IndexDTO;
use App\DTO\API_Client\Coins\StoreDTO;
use App\DTO\API_Client\Coins\UpdateDTO;
use App\Exceptions\Coin\DeleteCoinException;
use App\Exceptions\Coin\FindCoinException;
use App\Exceptions\Coin\IndexCoinsException;
use App\Exceptions\Coin\StoreCoinException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Coins\DeleteRequest;
use App\Http\Requests\API_Client\Coins\IndexRequest;
use App\Http\Requests\API_Client\Coins\StoreRequest;
use App\Http\Requests\API_Client\Coins\UpdateRequest;
use App\Http\Resources\Coin\CoinResource;
use App\Services\API_Client\Coin\CoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinController extends Controller
{
    private CoinService $service;
    public function __construct(CoinService $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $data = new IndexDTO($request->validated());

        try {
            $coins = $this->service->index($data);
        } catch (IndexCoinsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return CoinResource::collection($coins);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = new StoreDTO($request->validated());

        try {
            $this->service->store($data);
        } catch (StoreCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully created'], 201);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = new UpdateDTO($request->validated());

        try {
            $this->service->update($data);
        } catch (StoreCoinException|FindCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function delete(DeleteRequest $request): JsonResponse
    {
        $data = new DeleteDTO($request->validated());

        try {
            $this->service->delete($data);
        } catch (FindCoinException|DeleteCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }
}
