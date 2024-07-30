<?php

namespace App\DTO\API_Client\Currency;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $symbol;
}
