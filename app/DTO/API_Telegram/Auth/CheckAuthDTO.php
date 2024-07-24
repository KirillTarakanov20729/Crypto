<?php

namespace App\DTO\API_Telegram\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class CheckAuthDTO extends DataTransferObject
{
    public string $telegram_id;
}
