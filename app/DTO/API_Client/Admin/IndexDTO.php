<?php

namespace App\DTO\API_Client\Admin;

use Spatie\DataTransferObject\DataTransferObject;

class IndexDTO extends DataTransferObject
{
    public int $page;
}
