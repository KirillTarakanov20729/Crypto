<?php

namespace App\DTO\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LoginDTO extends DataTransferObject
{
    public string $email;
    public string $password;
}
