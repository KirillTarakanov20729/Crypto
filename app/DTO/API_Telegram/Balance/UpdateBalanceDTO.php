<?php

namespace App\DTO\API_Telegram\Balance;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateBalanceDTO extends DataTransferObject
{
    public string $user_telegram_id;
    public string $coin_symbol;
    public string $type;
    public string $amount;
}
