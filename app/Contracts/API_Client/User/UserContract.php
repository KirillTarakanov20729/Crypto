<?php

namespace App\Contracts\API_Client\User;

use App\DTO\API_Client\User\DeleteDTO;
use App\DTO\API_Client\User\IndexDTO;
use App\DTO\API_Client\User\StoreDTO;
use App\DTO\API_Client\User\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface UserContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;
    public function update(UpdateDTO $data): bool;
    public function delete(int $id): bool;

    public function show(int $id): Model;
}
