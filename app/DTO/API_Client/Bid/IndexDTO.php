<?php

namespace App\DTO\API_Client\Bid;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public int $page;
    public int $per_page;
    public? int $coin_id;
    public? string $user_email;
    public? int $currency_id;
}
