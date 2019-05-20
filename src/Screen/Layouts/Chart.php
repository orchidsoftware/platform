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
     * Set default colors or not.
     *
     * @var boolean
     */
    public $setColors = true;

    /**
     * Default colors used.
     *
     * @var array
     */

    //public $colors = ['#2274A5', '#F75C03', '#F1C40F', '#D90368', '#00CC66' ];
    //public $colors = ['#1f77b4', '#aec7e8', '#ff7f0e', '#ffbb78', '#2ca02c', '#98df8a', '#d62728', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5'];
    public $colors = ['#3366CC','#DC3912','#FF9900','#109618','#990099','#3B3EAC','#0099C6','#DD4477','#66AA00','#B82E2E','#316395','#994499','#22AA99','#AAAA11','#6633CC','#E67300','#8B0707','#329262','#5574A6','#3B3EAC'];

    public $options = [
        'title' => [
            'display' => true,
            'text' => 'Chart',
        ],
        'spanGaps' => true,
        'tooltips' => [
            'mode' => 'index',
            'intersect' => false,
        ],
        'scales' => [
            'yAxes' => [
                'stacked' => true,
            ],
        ],
        'legend' => [
            'position' => 'bottom',
        ],
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
            'options' => json_encode($this->options),
            'setcolors' => $this->setColors,
            'colors' => json_encode($this->colors),
        ]);
    }
}
