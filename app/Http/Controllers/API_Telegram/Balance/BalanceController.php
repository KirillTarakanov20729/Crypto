<?php

namespace App\Http\Controllers\API_Telegram\Balance;

use App\Contracts\API_Telegram\Balance\BalanceContract;
use App\DTO\API_Telegram\Balance\UpdateBalanceDTO;
use App\Exceptions\API_Telegram\Balance\FindUserException;
use App\Exceptions\API_Telegram\Balance\GetWalletsException;
use App\Exceptions\API_Telegram\Balance\UpdateBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Balance\UpdateBalanceRequest;
use App\Http\Resources\API_Client\WalletResource;
use App\Services\API_Telegram\Balance\BalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BalanceController extends Controller
{
    private BalanceContract $service;
    public function __construct(BalanceContract $service)
    {
        $this->service = $service;
    }

    public function show(int $telegram_id): JsonResponse|AnonymousResourceCollection
    {
        try {
            $wallets = $this->service->get_wallets($telegram_id);
        } catch (FindUserException|GetWalletsException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return WalletResource::collection($wallets);
    }

    public function update(UpdateBalanceRequest $request): JsonResponse
    {
        $data = new UpdateBalanceDTO($request->validated());

        try {
            $this->service->update_balance($data);
        } catch (FindUserException|UpdateBalanceException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['success' => true]);
    }
}
