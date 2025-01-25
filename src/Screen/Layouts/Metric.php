<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Metric.
 */
class Metric extends Layout
{

    protected string $template = 'platform::layouts.metric';

    protected ?string $title = null;

    protected array $labels = [];

    public function __construct(array $labels)
    {
        $this->labels = $labels;
    }

    /**
     * @param Repository $repository
     * @return View|null
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee() || empty($this->labels)) {
            return null;
        }

        $metrics = collect($this->labels)->map(fn (string $value) => $repository->getContent($value, ''));

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
