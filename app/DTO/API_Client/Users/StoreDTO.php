<?php

namespace App\DTO\API_Client\Users;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
    public string $telegram_id;
}
