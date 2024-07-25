<?php

namespace App\Http\Controllers\API_Client\User;

use App\DTO\API_Client\Users\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Users\IndexRequest;
use App\Http\Resources\User\UserResource;
use App\Services\API_Client\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request)
    {
        $data = new IndexDTO($request->validated());

        return UserResource::collection($this->service->index($data));
    }
}
