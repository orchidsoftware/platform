<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

abstract class Metric
{
    /**
     * @var string
     */
    private $template = 'platform::container.layouts.metric';

    /**
     * @var array
     */
    public $labels = [];

    /**
     * @var array
     */
    public $data = [];

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        $query->getContent($this->data);

        return view($this->template);
    }
}
