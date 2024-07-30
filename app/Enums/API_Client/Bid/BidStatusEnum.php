<?php declare(strict_types=1);

namespace App\Enums\API_Client\Bid;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static PENDING()
 * @method static static CLOSED()
 */
final class BidStatusEnum extends Enum
{
    const CREATED = 'created';
    const PENDING = 'pending';
    const CLOSED = 'closed';
}
