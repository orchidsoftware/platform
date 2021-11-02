<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts\Examples;

use Orchid\Screen\Layouts\Chart;

class ChartPieExample extends Chart
{
    /**
     * @var string
     */
    protected $title = 'Pie Chart';

    /**
     * @var int
     */
    protected $height = 350;

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * @var string
     */
    protected $target = 'charts';
}
