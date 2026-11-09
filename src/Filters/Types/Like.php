<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class Like extends BaseHttpEloquentFilter
{
    /**
     * Apply a substring condition using the available Laravel query API.
     */
    public function run(Builder $builder): Builder
    {
        $value = '%'.$this->getHttpValue().'%';

        return $builder->whereLike($this->column, $value);
    }
}
