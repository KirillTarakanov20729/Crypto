<?php

namespace App\Http\Controllers\API_Client\User;

use App\Contracts\API_Client\User\UserContract;
use App\DTO\API_Client\User\DeleteDTO;
use App\DTO\API_Client\User\IndexDTO;
use App\DTO\API_Client\User\StoreDTO;
use App\DTO\API_Client\User\UpdateDTO;
use App\Exceptions\API_Client\User\DeleteUserException;
use App\Exceptions\API_Client\User\FindUserException;
use App\Exceptions\API_Client\User\IndexUsersException;
use App\Exceptions\API_Client\User\StoreUserException;
use App\Exceptions\API_Client\User\UpdateUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\User\DeleteRequest;
use App\Http\Requests\API_Client\User\IndexRequest;
use App\Http\Requests\API_Client\User\StoreRequest;
use App\Http\Requests\API_Client\User\UpdateRequest;
use App\Http\Resources\API_Client\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private UserContract $service;
    public function __construct(UserContract $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $data = new IndexDTO($request->validated());

        try {
            $users = $this->service->index($data);
        } catch (IndexUsersException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return UserResource::collection($users);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = new StoreDTO($request->validated());

        try {
            $this->service->store($data);
        } catch (StoreUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully created'], 201);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = new UpdateDTO($request->validated());

        try {
            $this->service->update($data);
        } catch (UpdateUserException|FindUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (FindUserException|DeleteUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function show(int $id): UserResource|JsonResponse
    {
        try {
            $user = $this->service->show($id);
        } catch (FindUserException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return new UserResource($user);
    }
}
