<?php

namespace App\Contracts\API_Telegram\Payment;

use App\DTO\API_Telegram\Payment\ShowPaymentDTO;
use Illuminate\Database\Eloquent\Model;

interface PaymentContract
{
    public function show(ShowPaymentDTO $data): Model;
}
