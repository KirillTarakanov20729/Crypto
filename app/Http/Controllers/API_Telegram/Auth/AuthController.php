<?php

namespace App\Http\Controllers\API_Telegram\Auth;

use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;
use App\Exceptions\Auth\API_Telegram\ChangeLoginStatusException;
use App\Exceptions\Auth\API_Telegram\CheckAuthException;
use App\Exceptions\Auth\API_Telegram\FindUserException;
use App\Exceptions\Auth\API_Telegram\LoginException;
use App\Exceptions\Auth\API_Telegram\LoginTelegramIdException;
use App\Exceptions\Auth\API_Telegram\LogoutException;
use App\Exceptions\Auth\API_Telegram\StoreUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Telegram\Auth\CheckAuthRequest;
use App\Http\Requests\API_Telegram\Auth\LoginRequest;
use App\Http\Requests\API_Telegram\Auth\LogoutRequest;
use App\Http\Requests\API_Telegram\Auth\RegisterRequest;
use App\Services\API_Telegram\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $service;
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = new RegisterDTO($request->validated());

        try {
            $this->service->store_user($data);
        } catch (StoreUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'You have successfully registered'
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = new LoginDTO($request->validated());

        try {
            $this->service->check_credentials($data);
        } catch (LoginException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

       try {
           $this->service->check_telegram_id($data);
       } catch (LoginTelegramIdException|FindUserException $e) {
           return response()->json(['error' => $e->getMessage()], $e->getCode());
       }

       try {
           $this->service->change_login_status($data);
       } catch (ChangeLoginStatusException|FindUserException $e) {
           return response()->json(['error' => $e->getMessage()], $e->getCode());
       }

       return response()->json([
           'message' => 'You have successfully logged in'
       ], 200);
    }

    public function check_auth(CheckAuthRequest $request): JsonResponse
    {
        $data = new TelegramIdDTO($request->validated());

        try {
            $this->service->check_auth($data);
        } catch (CheckAuthException|FindUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'User is logged in'
        ], 200);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $data = new TelegramIdDTO($request->validated());

        try {
            $this->service->logout($data);
        } catch (LogoutException|FindUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'message' => 'You have successfully logged out'
        ], 200);
    }
}
