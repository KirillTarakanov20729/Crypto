<?php

namespace App\DTO\API_Client\Coins;

use Spatie\DataTransferObject\DataTransferObject;

class DeleteDTO extends DataTransferObject
{
    public string $id;
}
