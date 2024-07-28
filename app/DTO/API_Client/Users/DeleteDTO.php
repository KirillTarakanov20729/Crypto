<?php

namespace App\DTO\API_Client\Users;

use Spatie\DataTransferObject\DataTransferObject;

class DeleteDTO extends DataTransferObject
{
    public string $id;
}
