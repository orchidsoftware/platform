<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts\Examples;

use Orchid\Screen\Layouts\Chart;

class ChartBarExample extends Chart
{
    /**
     * @var string
     */
    protected $title = 'Bar Chart';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'bar';

    /**
     * @var string
     */
    protected $target = 'charts';
}
