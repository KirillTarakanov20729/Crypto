<?php

namespace App\DTO\API_Client\Coins;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $symbol;
    public string $price;
}
