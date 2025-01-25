<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\View\View;
use Orchid\Filters\Filter;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Selection.
 */
abstract class Selection extends Layout
{
    /**
     * Drop-down filters.
     */
    public const TEMPLATE_DROP_DOWN = 'platform::layouts.selection';

    /**
     * Line filters.
     */
    public const TEMPLATE_LINE = 'platform::layouts.filter';

    public string $template = self::TEMPLATE_DROP_DOWN;

    /**
     * @param Repository $repository
     * @return View|null
     */
    public function build(Repository $repository): ?View
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $filters = collect($this->filters())
            ->map(static fn ($filter) => is_string($filter) ? resolve($filter) : $filter)
            ->filter(fn (Filter $filter) => $filter->isDisplay());

        if ($filters->isEmpty()) {
            return null;
        }

        return view($this->template, [
            'filters' => $filters,
            'chunk'   => ceil($filters->count() / 4),
        ]);
    }

    /**
     * @return Filter[]
     */
    abstract public function filters(): iterable;
}
