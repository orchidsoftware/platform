<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class Ilike extends BaseHttpEloquentFilter
{
    /**
     * Apply a case-insensitive substring condition to the query.
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where(
            $this->column,
            'ILIKE',
            '%'.$this->getHttpValue().'%'
        );
    }
}
