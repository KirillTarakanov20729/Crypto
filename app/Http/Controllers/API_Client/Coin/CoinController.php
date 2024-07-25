<?php

namespace App\Http\Controllers\API_Client\Coin;

use App\DTO\API_Client\Coins\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Coins\IndexRequest;
use App\Http\Resources\Coin\CoinResource;
use App\Services\API_Client\Coin\CoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinController extends Controller
{
    private CoinService $service;
    public function __construct(CoinService $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $data = new IndexDTO($request->validated());

        return CoinResource::collection($this->service->index($data));
    }
}
