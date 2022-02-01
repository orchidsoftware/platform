<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
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
    protected $template = 'platform::layouts.metric';

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var array
     */
    protected $labels = [];

    /**
     * @param array $labels
     */
    public function __construct(array $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee() || empty($this->labels)) {
            return;
        }

        $metrics = collect($this->labels)->map(function (string $value) use ($repository) {
            return $repository->getContent($value, []);
        });

        return view($this->template, [
            'title'   => $this->title,
            'metrics' => $metrics,
        ]);
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function title(string $title): Metric
    {
        $this->title = $title;

        return $this;
    }
}
