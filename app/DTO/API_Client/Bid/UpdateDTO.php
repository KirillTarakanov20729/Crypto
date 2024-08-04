<?php

namespace App\DTO\API_Client\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateDTO extends DataTransferObject
{
    public int $id;
    public int $user_telegram_id;
    public int $coin_id;
    public int $currency_id;
    public int $amount;
    public int $price;
    public string $status;
    public string $type;
}
