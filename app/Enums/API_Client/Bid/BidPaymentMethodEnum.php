<?php declare(strict_types=1);

namespace App\Enums\API_Client\Bid;

use BenSampo\Enum\Enum;

/**
 * @method static static TINCOFF()
 * @method static static SBER()
 * @method static static ALFA()
 */
final class BidPaymentMethodEnum extends Enum
{
    const TINCOFF = "Tincoff";
    const SBER = "Sber";
    const ALFA = "Alfa-bank";
}
