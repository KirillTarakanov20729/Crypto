<?php

namespace App\Models;

use App\Traits\Filter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $symbol
 * @property string $price
 */
class Coin extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'symbol',
        'price',
    ];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }
}
