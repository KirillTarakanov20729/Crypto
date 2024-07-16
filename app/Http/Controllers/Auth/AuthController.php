<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function register(Request $request): JsonResponse
    {
        $this->service->store_user($request->all());

        return response()->json([
            'message' => 'User created successfully'
        ], 201);
    }
}
