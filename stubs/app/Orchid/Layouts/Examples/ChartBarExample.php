<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Layouts\Chart;

class ChartBarExample extends Chart
{
    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     */
    protected string $type = self::TYPE_BAR;

    /**
     * Height of the chart.
     */
    protected int $height = 300;
}
