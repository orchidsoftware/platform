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
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';

    /**
     * @var string
     */
    protected $target = 'charts';

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
