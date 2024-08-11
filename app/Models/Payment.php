<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @property string $uuid
 * @property int $request_user_telegram_id
 * @property int $response_user_telegram_id
 * @property string $uuid_bid
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'request_user_telegram_id',
        'response_user_telegram_id',
        'uuid_bid',
    ];

    public function requestUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_telegram_id', 'telegram_id');
    }

    public function responseUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'response_user_telegram_id', 'telegram_id');
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, 'uuid_bid', 'uuid');
    }
}
