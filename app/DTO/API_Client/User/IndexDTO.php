<?php

namespace App\DTO\API_Client\User;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public string $page;
    public? string $search;
}
