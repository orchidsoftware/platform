<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Repository;

/**
 * Class Chart.
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
     * 'bar', 'line', 'pie',
     * 'percentage', 'axis-mixed'.
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
     * @var string
     */
    public $data = '';


    /**
     * @var array
     */

    public $colors = [
        '#2274A5',
        '#F75C03',
        '#F1C40F',
        '#D90368',
        '#00CC66'
        /*
      '#d0dff9',
      '#a3c3f9',
      '#7da1dd',
      '#5580c7',
      '#2860bd',
      '#0a3f98',
      '#062457',
      '#0c182c',
        */
    ];

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
            'colors' => json_encode($this->colors),
        ]);
    }
}
