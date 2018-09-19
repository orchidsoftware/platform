<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;


abstract class Metric
{
    /**
     * @var string
     */
    private $template = 'platform::container.layouts.chart';

    /**
     * Available options:
     * 'bar', 'line', 'pie',
     * 'percentage', 'axis-mixed'.
     *
     * @var string
     */
    public $type = 'line';

    /**
     * @var array
     */
    public $labels = [];

    /**
     * @var array
     */
    public $data = [];
}