<?php

namespace App\Models;

use App\Enums\API_Client\Bid\BidPaymentMethodEnum;
use App\Enums\API_Client\Bid\BidStatusEnum;
use App\Enums\API_Client\Bid\BidTypeEnum;
use App\Traits\Filter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $coin_id
 * @property int $currency_id
 * @property int $amount
 * @property int $price
 * @property string $status
 * @property string $type
 * @property string $payment_method
 * @property string $number
 */
class Bid extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'uuid',
        'user_id',
        'coin_id',
        'currency_id',
        'amount',
        'price',
        'status',
        'type',
        'number',
        'payment_method'
    ];

    protected $casts = [
        'status' => BidStatusEnum::class,
        'type' => BidTypeEnum::class,
        'payment_method' => BidPaymentMethodEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
