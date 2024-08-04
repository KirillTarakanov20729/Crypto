<?php declare(strict_types=1);

namespace App\Enums\API_Client\Bid;

use BenSampo\Enum\Enum;

/**
 * @method static static SELL()
 * @method static static BUY()
 */
final class BidTypeEnum extends Enum
{
    const SELL = 'sell';
    const BUY = 'buy';
}
