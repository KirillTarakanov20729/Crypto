<?php declare(strict_types=1);

namespace App\Enums\API_Client\Bid;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static ASKED()
 * @method static static ANSWERED()
 * @method static static CLOSED()
 */
final class BidStatusEnum extends Enum
{
    const CREATED = 'created';
    const ASKED = 'asked';
    const ANSWERED = 'answered';
    const CLOSED = 'closed';
}
