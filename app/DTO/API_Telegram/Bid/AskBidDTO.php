<?php

namespace App\DTO\API_Telegram\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class AskBidDTO extends DataTransferObject
{
    public string $uuid;
    public string $user_telegram_id;
}
