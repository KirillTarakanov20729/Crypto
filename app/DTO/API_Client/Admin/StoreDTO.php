<?php

namespace App\DTO\API_Client\Admin;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public string $email;
    public string $password;
}
