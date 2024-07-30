<?php

namespace App\DTO\API_Client\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public int $user_id;
    public int $coin_id;
    public int $currency_id;
    public int $amount;
    public int $price;
}
