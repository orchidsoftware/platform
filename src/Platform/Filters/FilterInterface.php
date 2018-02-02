<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder;

    /**
     * @return mixed
     */
    public function display();
}
