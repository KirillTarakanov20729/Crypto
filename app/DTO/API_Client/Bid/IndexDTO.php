<?php

namespace App\DTO\API_Client\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public int $page;
    public? int $coin_id;
    public? int $user_id;
    public? int $currency_id;

}
