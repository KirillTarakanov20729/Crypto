<?php

namespace App\Http\Controllers\API_Client\Admin;

use App\Contracts\API_Client\Admin\AdminContract;
use App\DTO\API_Client\Admin\IndexDTO;
use App\DTO\API_Client\Admin\StoreDTO;
use App\DTO\API_Client\Admin\UpdateDTO;
use App\Exceptions\API_Client\Admin\DeleteAdminException;
use App\Exceptions\API_Client\Admin\FindAdminException;
use App\Exceptions\API_Client\Admin\IndexAdminsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API_Client\Admin\IndexRequest;
use App\Http\Requests\API_Client\Admin\StoreRequest;
use App\Http\Requests\API_Client\Admin\UpdateRequest;
use App\Http\Resources\API_Client\AdminResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminController extends Controller
{
    private AdminContract $service;

    public function __construct(AdminContract $service)
    {
        $this->service = $service;
    }

    public function index(IndexRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexDTO($request->validated());

        try {
            $admins = $this->service->index($data);
        } catch (IndexAdminsException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return AdminResource::collection($admins);
    }

    public function show(int $id): JsonResponse|AdminResource
    {
        try {
            $admin = $this->service->show($id);
        } catch (FindAdminException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return new AdminResource($admin);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
        } catch (FindAdminException|DeleteAdminException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully deleted'], 200);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $data = new UpdateDTO($request->validated());

        try {
            $this->service->update($data);
        } catch (FindAdminException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully updated'], 200);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = new StoreDTO($request->validated());

        try {
            $this->service->store($data);
        } catch (FindAdminException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Successfully created'], 201);
    }
}
