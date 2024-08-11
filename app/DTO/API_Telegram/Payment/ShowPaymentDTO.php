<?php

namespace App\DTO\API_Telegram\Payment;

use Spatie\DataTransferObject\DataTransferObject;

class ShowPaymentDTO extends DataTransferObject
{
    public string $uuid;
}
