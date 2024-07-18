<?php

namespace App\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class CheckAuthDTO extends DataTransferObject
{
    public string $telegram_id;
}
