<?php

namespace App\DTO\API_Client\Users;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $telegram_id;
    public bool $is_logged_in;
}
