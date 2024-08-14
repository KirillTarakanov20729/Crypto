<?php

namespace App\DTO\API_Telegram\Bid\Payment;

use Spatie\DataTransferObject\DataTransferObject;

class ResponseBidDTO extends DataTransferObject
{
    public string $uuid;
    public string $user_telegram_id;
}
