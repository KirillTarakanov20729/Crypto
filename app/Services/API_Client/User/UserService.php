<?php

namespace App\Services\API_Client\User;

use App\Contracts\API_Client\User\UserContract;
use App\DTO\API_Client\User\StoreDTO;
use App\DTO\API_Client\User\UpdateDTO;
use App\DTO\API_Client\User\IndexDTO;
use App\Exceptions\API_Client\User\DeleteUserException;
use App\Exceptions\API_Client\User\FindUserException;
use App\Exceptions\API_Client\User\StoreUserException;
use App\Exceptions\API_Client\User\IndexUsersException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserService implements UserContract
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return User::query()->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexUsersException('Something went wrong', 500);
        }
    }

    public function store(StoreDTO $data): bool
    {
        try {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = bcrypt($data->password);
            $user->telegram_id = $data->telegram_id;
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException('Something went wrong', 500);
        }

        return true;
    }

    public function update(UpdateDTO $data): bool
    {
        try {
            /** @var User $user */
            $user = User::query()->findOrFail($data->id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindUserException('User not found', 404);
        }

        try {
            $user->name = $data->name;
            $user->email = $data->email;
            $user->telegram_id = $data->telegram_id;
            $user->is_logged_in = $data->is_logged_in;
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new StoreUserException('Something went wrong', 500);
        }

        return true;
    }

    public function delete(int $id): bool
    {
        try {
            $user = User::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindUserException('User not found', 404);
        }

        try {
            $user->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeleteUserException('Something went wrong', 500);
        }

        return true;
    }

    public function show(int $id): Model
    {
        try {
            return User::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindUserException('User not found', 404);
        }
    }
}
