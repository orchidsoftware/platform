<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Layouts\Chart;

class ChartLineExample extends Chart
{
    /**
     * @var string
     */
    protected $title = 'Line Chart';

    /**
     * @var string
     */
    protected $target = 'charts';

    /**
     * Configuring line.
     *
     * @var array
     */
    protected $lineOptions = [
        'spline'     => 1,
        'regionFill' => 1,
        'hideDots'   => 0,
        'hideLine'   => 0,
        'heatline'   => 0,
        'dotSize'    => 3,
    ];

    /**
     * To highlight certain values on the Y axis, markers can be set.
     * They will shown as dashed lines on the graph.
     */
    protected function markers(): ?array
    {
        return [
            [
                'label'   => 'Medium',
                'value'   => 40,
            ],
        ];
    }
}
