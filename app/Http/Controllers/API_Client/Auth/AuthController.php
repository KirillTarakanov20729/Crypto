<?php

namespace App\Http\Controllers\API_Client\Auth;

use App\DTO\API_Client\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Auth\LoginRequest;
use App\Services\API_Client\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $service;
    public function __construct(AuthService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = new LoginDTO($request->validated());

        if (!$token = auth()->attempt($data->toArray())) {
            return response()->json(['error' => 'Wrong password or email'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
