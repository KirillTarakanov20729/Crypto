<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::SEARCH => [$this, 'search']
        ];
    }

    public function search(Builder $builder, $value): void
    {
        $builder->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('telegram_id', 'like', "%{$value}%");
    }
}
