<?php declare(strict_types=1);

namespace App\Enums\API_Client\Bid;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static ASKED()
 * @method static static RESPONSE()
 * @method static static PAID()
 * @method static static COMPLETED()
 */
final class BidStatusEnum extends Enum
{
    const CREATED = 'created';
    const ASKED = 'asked';

    const RESPONSE = 'response';

    const PAID = 'paid';
    const COMPLETED = 'completed';
}
