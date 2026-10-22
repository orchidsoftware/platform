<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Metric.
 */
class Metric extends Layout
{
    /**
     * @var string
     */
    protected $template = 'orchid::layouts.metric';

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var array
     */
    protected $labels = [];

    /**
     * Initialize the labels displayed by the metric layout.
     */
    public function __construct(array $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @return Factory|View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee() || empty($this->labels)) {
            return;
        }

        $metrics = collect($this->labels)->map(function (string $value) use ($repository) {
            $metric = $repository->getContent($value, '');

            if (is_array($metric) && isset($metric['diff']) && (float) $metric['diff'] !== 0.0) {
                $metric['formattedDiff'] = round($metric['diff'], 2);
            }

            return $metric;
        });

        return view($this->template, [
            'title'   => $this->title,
            'metrics' => $metrics,
        ]);
    }

    /**
     * @return $this
     */
    public function title(string $title): Metric
    {
        $this->title = $title;

        return $this;
    }
}
