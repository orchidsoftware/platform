<?php namespace App\Http\Filters\Exhibitions;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;

class DummyClass extends Filter
{

    /**
     *
     * @var array
     */
    public $parameters = [];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = false;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
    }
}
