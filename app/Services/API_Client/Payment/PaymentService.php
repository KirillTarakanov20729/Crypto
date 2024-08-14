<?php

namespace App\Services\API_Client\Payment;

use App\Contracts\API_Client\Payment\PaymentContract;
use App\DTO\API_Client\Payment\IndexDTO;
use App\Exceptions\API_Client\Payment\DeletePaymentException;
use App\Exceptions\API_Client\Payment\FindPaymentException;
use App\Exceptions\API_Client\Payment\IndexPaymentException;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class PaymentService implements PaymentContract
{

    public function index(IndexDTO $data): LengthAwarePaginator
    {
        try {
            return Payment::query()->paginate(10, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexPaymentException('Something went wrong', 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $payment = Payment::query()->findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new FindPaymentException('Payment not found', 404);
        }

        try {
            $payment->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new DeletePaymentException('Something went wrong', 500);
        }

        return true;
    }
}
