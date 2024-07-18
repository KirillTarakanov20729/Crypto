<?php

namespace App\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class RegisterDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
    public string $telegram_id;
}
