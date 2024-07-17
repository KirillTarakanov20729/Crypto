<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Exceptions\Auth\StoreUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
                'message' => 'Произошла ошибка'
            ], 400);
        }

        return response()->json([
            'message' => 'Вы успешно зарегистрировались'
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = new LoginDTO($request->validated());
        if ($this->service->login($data)) {
            return response()->json([
                'message' => 'Вы успешно вошли в систему'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Неверный логин или пароль'
            ], 401);
        }
    }
}
