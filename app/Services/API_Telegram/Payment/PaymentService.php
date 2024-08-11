<?php

namespace App\Services\API_Telegram\Payment;

use App\Contracts\API_Telegram\Payment\PaymentContract;
use App\DTO\API_Telegram\Payment\ShowPaymentDTO;
use App\Exceptions\API_Telegram\Payment\ShowPaymentException;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PaymentService implements PaymentContract
{
    public function show(ShowPaymentDTO $data): Model
    {
        try {
            $payment = Payment::query()->where('uuid', $data->uuid)->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new ShowPaymentException('Error show payment', 500);
        }

        return $payment;
    }
}
