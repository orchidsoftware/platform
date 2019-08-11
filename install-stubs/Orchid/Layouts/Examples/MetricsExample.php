<?php

namespace App\Orchid\Layouts\Examples;

use Orchid\Screen\Layouts\Metric;

class MetricsExample extends Metric
{
    /**
     * @var string
     */
    public $title = 'Metric Today';

    /**
     * @var string
     */
    public $target = 'metrics';

    /**
     * @var array
     */
    public $labels = [
        'Sales Today',
        'Visitors Today',
        'Total Earnings',
        'Pending Orders',
        'Total Revenue',
    ];
}
