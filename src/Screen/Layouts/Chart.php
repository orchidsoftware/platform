<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use Orchid\Screen\Repository;

/**
 * Class Chart.
 */
abstract class Chart extends Base
{
    /**
     * Main template to display the layer
     * Represents the view() argument.
     *
     * @var string
     */
    protected $template = 'platform::layouts.chart';

    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'My Chart';

    /**
     * Available options:
     * 'bar', 'line', 'pie',
     * 'percentage', 'axis-mixed'.
     *
     * @var string
     */
    protected $type = 'line';

    /**
     * @var int
     */
    protected $height = 250;

    /**
     * Set the labels for each possible field value.
     *
     * @var array
     */
    protected $labels = [];

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = '';

    /**
     * Colors used.
     *
     * @var array
     */
    protected $colors = [
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
    protected $export = true;

    /**
     * Limiting the slices.
     *
     * When there are too many data values to show visually,
     * it makes sense to bundle up the least of the values as a cumulated data point,
     * rather than showing tiny slices.
     *
     * @var int
     */
    protected $maxSlices = 7;

    /**
     * To display data values over bars or dots in an axis graph.
     *
     * @var int
     */
    protected $valuesOverPoints = 0;

    /**
     * Configuring percentage bars.
     *
     * @var array
     */
    protected $barOptions = [
        'spaceRatio' => 0.5,
        'stacked'    => 0,
        'height'     => 20,
        'depth'      => 2,
    ];

    /**
     * Configuring line.
     *
     * @var array
     */
    protected $lineOptions = [
        'regionFill' => 0,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'heatline'   => 0,
        'dotSize'    => 4,
    ];

    /**
     * Configuring axios.
     *
     * @var array
     */
    protected $axisOptions = [
        'xIsSeries'  => false,
        'xAxisMode'  => 'span', //'tick'
    ];

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        return view($this->template, [
            'title'            => $this->title,
            'slug'             => Str::slug($this->title),
            'type'             => $this->type,
            'height'           => $this->height,
            'labels'           => json_encode(collect($this->labels)),
            'data'             => json_encode($repository->getContent($this->target)),
            'colors'           => json_encode($this->colors),
            'maxSlices'        => json_encode($this->maxSlices),
            'valuesOverPoints' => json_encode($this->valuesOverPoints),
            'axisOptions'      => json_encode($this->axisOptions),
            'barOptions'       => json_encode($this->barOptions),
            'lineOptions'      => json_encode($this->lineOptions),
        ]);
    }
}
