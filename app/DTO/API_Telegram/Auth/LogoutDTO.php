<?php

namespace App\DTO\API_Telegram\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LogoutDTO extends DataTransferObject
{
    public string $telegram_id;
}
