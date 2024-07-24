<?php

namespace App\Http\Controllers\API_Client\Coin;

use App\Http\Controllers\Controller;
use App\Services\API_Client\Coin\CoinService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    private CoinService $service;
    public function __construct(CoinService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $coins = $this->service->index();

        return response()->json($coins, 200);
    }
}
