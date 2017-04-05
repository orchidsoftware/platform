<?php namespace Orchid\Filters;

use Orchid\Core\Builders\PostBuilder;

interface FilterInterface
{

    /**
     * @param PostBuilder $builder
     *
     * @return PostBuilder
     */
    public function run(PostBuilder $builder): PostBuilder;

    /**
     * @return mixed
     */
    public function display();

}
