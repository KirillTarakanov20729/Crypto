<?php

namespace App\DTO\API_Client\Admin;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $email;
    public string $password;
}
