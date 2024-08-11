<?php

namespace App\DTO\API_Telegram\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public int $page;
    public string $user_telegram_id;
}
