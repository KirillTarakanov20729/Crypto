<?php

namespace App\Contracts\API_Client\Admin;

use App\DTO\API_Client\Admin\IndexDTO;
use App\DTO\API_Client\Admin\StoreDTO;
use App\DTO\API_Client\Admin\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface AdminContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function show(int $id): Model;

    public function delete(int $id): bool;

    public function update(UpdateDTO $data): bool;

    public function store(StoreDTO $data): bool;

}
