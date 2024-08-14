<?php

namespace App\Contracts\API_Client\Payment;

use App\DTO\API_Client\Payment\IndexDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentContract
{
    public function index(IndexDTO $data): LengthAwarePaginator;

    public function delete(int $id): bool;
}
