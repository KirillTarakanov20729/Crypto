<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property int $coin_id
 * @property string $balance
 * @property string $uuid
 */

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coin_id',
        'balance',
        'uuid'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }
}
