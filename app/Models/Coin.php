<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
