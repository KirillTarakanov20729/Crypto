<?php

namespace App\DTO\API_Client\Coin;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $symbol;
    public string $price;
}
