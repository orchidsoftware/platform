<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Chart
 */
abstract class Chart
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.chart';

    /**
     * @var string
     */
    public $title = 'My Chart';

    /**
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    public $type = 'line';

    /**
     * @var int
     */
    public $height = 250;

    /**
     * @var array
     */
    public $labels = [];

    /**
     * @var array
     */
    public $data = '';

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        return view($this->template, [
            'title'  => $this->title,
            'slug'   => str_slug($this->title),
            'type'   => $this->type,
            'height' => $this->height,
            'labels' => json_encode(collect($this->labels)),
            'data'   => json_encode($query->getContent($this->data)),
        ]);
    }
}
