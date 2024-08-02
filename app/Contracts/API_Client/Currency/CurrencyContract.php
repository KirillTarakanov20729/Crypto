<?php

namespace App\Contracts\API_Client\Currency;

use App\DTO\API_Client\Currency\IndexDTO;
use App\DTO\API_Client\Currency\StoreDTO;
use App\DTO\API_Client\Currency\UpdateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CurrencyContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function store(StoreDTO $data): bool;

    public function update(UpdateDTO $data): bool;

    public function delete(int $id): bool;

    public function show(int $id): Model;

    public function all(): Collection;
}
