<?php

namespace App\DTO\API_Telegram\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class TelegramIdDTO extends DataTransferObject
{
    public string $telegram_id;
}
