<?php

namespace App\DTO\API_Client\Currency;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public string $name;
    public string $symbol;
}
