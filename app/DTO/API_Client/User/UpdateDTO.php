<?php

namespace App\DTO\API_Client\User;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $email;
    public string $telegram_id;
    public bool $is_logged_in;
}
