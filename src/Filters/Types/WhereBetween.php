<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class WhereBetween extends BaseHttpEloquentFilter
{
    /**
     * Constrain the column to the submitted value range.
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereBetween($this->column, $this->getHttpValue());
    }
}
