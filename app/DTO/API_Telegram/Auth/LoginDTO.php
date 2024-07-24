<?php

namespace App\DTO\API_Telegram\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LoginDTO extends DataTransferObject
{
    public string $email;
    public string $password;
    public string $telegram_id;
}
