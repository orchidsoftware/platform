<?php

declare(strict_types=1);

namespace Orchid\Filters\Types;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Orchid\Filters\BaseHttpEloquentFilter;

class WhereIn extends BaseHttpEloquentFilter
{
    public function run(Builder $builder): Builder
    {
        $query = $this->getHttpValue();

        $value = is_array($query) ? $query : Str::of($query)->explode(',');

        return $builder->whereIn($this->column, $value);
    }
}
