<?php

namespace App\Http\Controllers\API_Client\Coin;

use App\Contracts\API_Client\Coin\CoinContract;
use App\DTO\API_Client\Coin\IndexDTO;
use App\DTO\API_Client\Coin\StoreDTO;
use App\DTO\API_Client\Coin\UpdateDTO;
use App\Exceptions\API_Client\Coin\DeletecoinException;
use App\Exceptions\API_Client\Coin\FindcoinException;
use App\Exceptions\API_Client\Coin\IndexCoinsException;
use App\Exceptions\API_Client\Coin\StorecoinException;
use App\Exceptions\API_Client\Coin\UpdateCoinException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Coin\IndexRequest;
use App\Http\Requests\API_Client\Coin\StoreRequest;
use App\Http\Requests\API_Client\Coin\UpdateRequest;
use App\Http\Resources\API_Client\CoinResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinController extends Controller
{
    private CoinContract $service;
    public function __construct(CoinContract $service)
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
        } catch (UpdateCoinException|FindCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (FindCoinException|DeleteCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function show(int $id): CoinResource|JsonResponse
    {
        try {
            $coin = $this->service->show($id);
        } catch (FindCoinException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return new CoinResource($coin);
    }
}
