<?php

namespace App\DTO\API_Client\Auth;

use Spatie\DataTransferObject\DataTransferObject;

class LoginDTO extends DataTransferObject
{
    public string $email;
    public string $password;
}
