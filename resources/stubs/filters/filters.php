<?php namespace App\Http\Filters;

use Orchid\Core\Builders\PostBuilder;
use Orchid\Filters\Filter;

class CategoryFilters extends Filter
{
    /**
     * @param PostBuilder $builder
     *
     * @return PostBuilder
     */
    public function run(PostBuilder $builder): PostBuilder
    {
        return $builder;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {

    }
}
