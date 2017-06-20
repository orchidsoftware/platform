<?php namespace Orchid\Filters;

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
