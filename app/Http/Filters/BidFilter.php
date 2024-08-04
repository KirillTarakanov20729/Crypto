<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BidFilter extends AbstractFilter
{
    public const USER_ID = 'user_id';
    public const COIN_ID = 'coin_id';
    public const CURRENCY_ID = 'currency_id';


    protected function getCallbacks(): array
    {
        return [
            self::USER_ID => [$this, 'user_id'],
            self::COIN_ID => [$this, 'coin_id'],
            self::CURRENCY_ID => [$this, 'currency_id']
        ];
    }

    public function user_id(Builder $builder, $value): void
    {
        $builder->where('user_id', $value);
    }

    public function coin_id(Builder $builder, $value): void
    {
        $builder->where('coin_id', $value);
    }

    public function currency_id(Builder $builder, $value): void
    {
        $builder->where('currency_id', $value);
    }

}
