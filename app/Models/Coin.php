<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $symbol
 * @property float $price
 */
class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'price',
    ];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
