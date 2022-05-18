<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Chart.
 */
abstract class Chart extends Layout
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
     * Height of the chart.
     *
     * @var int
     */
    protected $height = 250;

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
        '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
        '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
        '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
        '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089',
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
        'spline'     => 0,
    ];

    /**
     * Configuring axios.
     *
     * @var array
     */
    protected $axisOptions = [
        'xIsSeries'  => true,
        'xAxisMode'  => 'span', //'tick'
    ];

    /**
     * To highlight certain values on the Y axis, markers can be set.
     * They will show as dashed lines on the graph.
     */
    protected function markers(): ?array
    {
        return null;
    }

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $labels = collect($repository->getContent($this->target))
                ->map(function ($item) {
                    return $item['labels'] ?? [];
                })
                ->flatten()
                ->unique()
                ->toJson(JSON_NUMERIC_CHECK);

        return view($this->template, [
            'title'            => __($this->title),
            'slug'             => Str::slug($this->title),
            'type'             => $this->type,
            'height'           => $this->height,
            'labels'           => $labels,
            'export'           => $this->export,
            'data'             => json_encode($repository->getContent($this->target), JSON_NUMERIC_CHECK),
            'colors'           => json_encode($this->colors),
            'maxSlices'        => json_encode($this->maxSlices),
            'valuesOverPoints' => json_encode($this->valuesOverPoints),
            'axisOptions'      => json_encode($this->axisOptions),
            'barOptions'       => json_encode($this->barOptions),
            'lineOptions'      => json_encode($this->lineOptions),
            'markers'          => json_encode($this->markers()),
        ]);
    }
}
