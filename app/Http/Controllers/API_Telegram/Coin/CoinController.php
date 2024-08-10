<?php

namespace App\Http\Controllers\API_Telegram\Coin;

use App\Contracts\API_Telegram\Coin\CoinContract;
use App\Exceptions\API_Client\Coin\AllCoinsException;
use App\Http\Controllers\Controller;
use App\Http\Resources\API_Telegram\CoinResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinController extends Controller
{
    private CoinContract $service;

    public function __construct(CoinContract $service)
    {
        $this->service = $service;
    }

    public function all(Request $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $coins = $this->service->all();
        } catch (AllCoinsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return CoinResource::collection($coins);
    }
}
