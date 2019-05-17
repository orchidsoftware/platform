<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Chart.
 */
abstract class Chart extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.chart';

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
     * Colors used.
     *
     * @var array
     */
    public $colors = [
        '#2274A5',
        '#F75C03',
        '#F1C40F',
        '#D90368',
        '#00CC66',
    ];

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    public $export = true;

    /**
     * @param Repository $query
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $query)
    {
        return view($this->template, [
            'title'  => $this->title,
            'slug'   => Str::slug($this->title),
            'type'   => $this->type,
            'height' => $this->height,
            'labels' => json_encode(collect($this->labels)),
            'data'   => json_encode($query->getContent($this->data)),
            'colors' => json_encode($this->colors),
        ]);
    }
}
