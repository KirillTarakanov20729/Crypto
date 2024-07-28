<?php

namespace App\Contracts\API_Client\User;

use App\DTO\API_Client\Users\DeleteDTO;
use App\DTO\API_Client\Users\IndexDTO;
use App\DTO\API_Client\Users\StoreDTO;
use App\DTO\API_Client\Users\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;
    public function update(UpdateDTO $data): bool;
    public function delete(DeleteDTO $data): bool;
}
