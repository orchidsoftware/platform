<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
