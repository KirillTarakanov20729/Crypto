<?php

namespace App\DTO\API_Telegram\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public int $page;
    public? int $coin_id;
}
