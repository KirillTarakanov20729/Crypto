<?php

namespace App\DTO\API_Telegram\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class StoreDTO extends DataTransferObject
{
    public int $user_telegram_id;
    public string $coin_symbol;
    public string $currency_symbol;
    public string $price;
    public string $amount;
    public string $type;
    public string $payment_method;
    public? string $number;
}
