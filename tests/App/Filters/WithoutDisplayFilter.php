<?php

namespace Orchid\Tests\App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;

class WithoutDisplayFilter extends Filter
{
    public function run(Builder $builder): Builder
    {
        return $builder;
    }
}
