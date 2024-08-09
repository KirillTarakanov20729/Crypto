<?php

namespace App\Http\Controllers\API_Telegram\Coin;

use App\Exceptions\API_Client\Coin\AllCoinsException;
use App\Http\Controllers\Controller;
use App\Http\Resources\API_Client\CoinResource;
use App\Services\API_Telegram\Coin\CoinService;
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
