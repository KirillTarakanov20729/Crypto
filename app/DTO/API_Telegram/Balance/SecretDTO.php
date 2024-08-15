<?php

namespace App\DTO\API_Telegram\Balance;

use Spatie\DataTransferObject\DataTransferObject;

class SecretDTO extends DataTransferObject
{
    public string $user_telegram_id;
}
