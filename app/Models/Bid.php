<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $coin_id
 * @property int $currency_id
 * @property int $amount
 * @property int $price
 * @property string $status
 */
class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coin_id',
        'currency_id',
        'amount',
        'price',
        'status'
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
