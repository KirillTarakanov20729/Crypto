<?php

namespace App\DTO\API_Telegram\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public int $user_telegram_id;
    public int $coin_id;
    public int $currency_id;
    public string $price;
    public string $amount;
    public string $type;
    public string $payment_method;
    public string $number;
}
