<?php

namespace App\DTO\API_Client\Coin;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public string $name;
    public string $symbol;
    public string $price;
}
