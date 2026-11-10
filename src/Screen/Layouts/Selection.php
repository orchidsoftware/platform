<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Filters\Filter;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Selection.
 *
 * @phpstan-consistent-constructor
 */
class Selection extends Layout
{
    public function __construct(protected array $filters = []) {}

    public static function make(array $filters = []): static
    {
        return new static($filters);
    }

    /**
     * Drop-down filters.
     */
    public const TEMPLATE_DROP_DOWN = 'orchid::layouts.selection';

    /**
     * Line filters.
     */
    public const TEMPLATE_LINE = 'orchid::layouts.filter';

    /**
     * @var string
     */
    public $template = self::TEMPLATE_DROP_DOWN;

    public function inline(): self
    {
        $this->template = self::TEMPLATE_LINE;

        return $this;
    }

    /**
     * @return Factory|View|mixed
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $filters = collect($this->filters())
            ->map(static fn ($filter) => is_string($filter) ? resolve($filter) : $filter)
            ->filter(fn (Filter $filter) => $filter->isDisplay());

        if ($filters->isEmpty()) {
            return;
        }

        return view($this->template, [
            'filters' => $filters,
            'chunk'   => ceil($filters->count() / 4),
        ]);
    }

    /**
     * @return iterable<Filter|class-string<Filter>>
     */
    public function filters(): iterable
    {
        return $this->filters;
    }
}
