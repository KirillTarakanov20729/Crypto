<?php

namespace App\Http\Controllers\API_Telegram\Auth;

use App\DTO\API_Telegram\Auth\LoginDTO;
use App\DTO\API_Telegram\Auth\RegisterDTO;
use App\DTO\API_Telegram\Auth\TelegramIdDTO;
use App\Exceptions\Auth\CheckAuthException;
use App\Exceptions\Auth\LoginTelegramIdException;
use App\Exceptions\Auth\LogoutException;
use App\Exceptions\Auth\StoreUserException;
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
            return response()->json([
                'message' => 'An error has occurred'
            ], 400);
        }

        return response()->json([
            'message' => 'You have successfully registered'
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = new LoginDTO($request->validated());

        if ($this->service->login($data)) {
            try {
                $this->service->check_telegram_id($data);
            } catch (LoginTelegramIdException $e) {
                return response()->json([
                    'message' => 'The wallet is linked to another telegram id'
                ], 400);
            }

            $telegram_data = new TelegramIdDTO(['telegram_id' => $data->telegram_id]);

            try {
                $this->service->change_login_status($telegram_data);
            } catch (LoginTelegramIdException $e) {
                return response()->json([
                    'message' => 'An error has occurred'
                ], 400);
            }

            return response()->json([
                'message' => 'You have successfully logged in'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Wrong email or password'
            ], 401);
        }
    }

    public function check_auth(CheckAuthRequest $request): JsonResponse
    {
        $data = new TelegramIdDTO($request->validated());

        try {
            if ($this->service->check_auth($data)) {
                return response()->json([
                    'message' => 'You are logged in'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'You are not logged in'
                ], 401);
            }
        } catch (CheckAuthException $e) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $data = new TelegramIdDTO($request->validated());
        try {
            $this->service->logout($data);
        } catch (LogoutException $e) {
            return response()->json([
                'message' => 'Error'
            ], 404);
        }

        return response()->json([
            'message' => 'You have successfully logged out'
        ], 200);
    }
}
