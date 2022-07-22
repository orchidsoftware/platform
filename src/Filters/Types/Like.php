<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class Like extends BaseHttpEloquentFilter
{
    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where($this->column, 'like', $this->getHttpValue());
    }
}
