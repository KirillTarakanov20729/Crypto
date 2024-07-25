<?php

namespace App\Services\API_Client\User;

use App\DTO\API_Client\Users\IndexDTO;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function index(IndexDTO $data): LengthAwarePaginator
    {
        return User::query()->paginate(10, ['*'], 'page', $data->page);
    }
}
