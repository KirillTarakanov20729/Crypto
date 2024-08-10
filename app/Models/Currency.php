<?php

namespace App\Models;

use App\Traits\Filter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $symbol
 */
class Currency extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'symbol',
    ];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
