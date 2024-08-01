<?php

namespace App\Services\API_Client\Admin;

use App\Contracts\API_Client\Admin\AdminContract;
use App\DTO\API_Client\Admin\IndexDTO;
use App\DTO\API_Client\Admin\StoreDTO;
use App\DTO\API_Client\Admin\UpdateDTO;
use App\Exceptions\API_Client\Admin\DeleteAdminException;
use App\Exceptions\API_Client\Admin\FindAdminException;
use App\Exceptions\API_Client\Admin\IndexAdminsException;
use App\Exceptions\API_Client\Admin\StoreAdminException;
use App\Exceptions\API_Client\Admin\UpdateAdminException;
use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AdminService implements AdminContract
{

    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Admin::query()->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexAdminsException('Something went wrong', 500);
        }
    }

    public function show(int $id): Model
    {
        try {
            return Admin::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindAdminException('Something went wrong', 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $admin = Admin::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindAdminException('Admin not found', 404);
        }

        try {
            $admin->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteAdminException('Something went wrong', 500);
        }

        return true;
    }

    public function update(UpdateDTO $data): bool
    {
        try {
            /** @var Admin $admin */
            $admin = Admin::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindAdminException('Admin not found', 404);
        }

        try {
            $admin->email = $data->email;
            $admin->password = $data->password;
            $admin->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new UpdateAdminException('Something went wrong', 500);
        }

        return true;
    }

    public function store(StoreDTO $data): bool
    {
        try {
            $admin = new Admin();
            $admin->email = $data->email;
            $admin->password = $data->password;
            $admin->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreAdminException('Something went wrong', 500);
        }

        return true;
    }
}
