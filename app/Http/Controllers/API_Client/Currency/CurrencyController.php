<?php

namespace App\Http\Controllers\API_Client\Currency;

use App\Contracts\API_Client\Currency\CurrencyContract;
use App\DTO\API_Client\Currency\IndexDTO;
use App\DTO\API_Client\Currency\StoreDTO;
use App\DTO\API_Client\Currency\UpdateDTO;
use App\Exceptions\API_Client\Currency\DeleteCurrencyException;
use App\Exceptions\API_Client\Currency\FindCurrencyException;
use App\Exceptions\API_Client\Currency\IndexCurrenciesException;
use App\Exceptions\API_Client\Currency\StoreCurrencyException;
use App\Exceptions\API_Client\Currency\UpdateCurrencyException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Currency\IndexRequest;
use App\Http\Requests\API_Client\Currency\StoreRequest;
use App\Http\Requests\API_Client\Currency\UpdateRequest;
use App\Http\Resources\API_Client\CurrencyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    private CurrencyContract $service;

    public function __construct(CurrencyContract $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request):AnonymousResourceCollection|JsonResponse
    {
        $data = new IndexDTO($request->validated());

        try {
            $currencies = $this->service->index($data);
        } catch (IndexCurrenciesException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return CurrencyResource::collection($currencies);
    }

    public function show(int $id): CurrencyResource|JsonResponse
    {
        try {
            $currency = $this->service->show($id);
        } catch (FindCurrencyException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return new CurrencyResource($currency);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = new StoreDTO($request->validated());

        try {
            $this->service->store($data);
        } catch (StoreCurrencyException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully created'], 201);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (FindCurrencyException|DeleteCurrencyException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = new UpdateDTO($request->validated());

        try {
            $this->service->update($data);
        } catch (UpdateCurrencyException|FindCurrencyException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
    }


}
