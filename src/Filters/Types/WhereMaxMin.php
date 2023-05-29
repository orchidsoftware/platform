<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\BaseHttpEloquentFilter;

class WhereMaxMin extends BaseHttpEloquentFilter
{
    public function run(Builder $builder): Builder
    {
        $value = $this->getHttpValue();

        $builder->when($value['min'] ?? null, fn (Builder $query) => $query->where($this->column, '>=', $value['min']));
        $builder->when($value['max'] ?? null, fn (Builder $query) => $query->where($this->column, '<=', $value['max']));

        return $builder;
    }
}
