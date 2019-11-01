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
     * @var string
     */
    protected $template = 'platform::layouts.chart';

    /**
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
     * @var array
     */
    protected $labels = [];

    /**
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
            'title'  => $this->title,
            'slug'   => Str::slug($this->title),
            'type'   => $this->type,
            'height' => $this->height,
            'labels' => json_encode(collect($this->labels)),
            'data'   => json_encode($repository->getContent($this->target)),
            'colors' => json_encode($this->colors),
        ]);
    }
}
