<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Screen\Concerns\HasEmptyState;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

/**
 * Class Table.
 *
 * @phpstan-consistent-constructor
 */
class Table extends Layout
{
    public function __construct(protected string $target, protected array $columns)
    {
        if ($target === '') {
            throw new \InvalidArgumentException('The layout data source must not be empty.');
        }
    }

    public static function make(string $target, array $columns): static
    {
        return new static($target, $columns);
    }

    use HasEmptyState;

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.table';

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Table title.
     *
     * The string to be displayed on top of the table.
     *
     * @var string
     */
    protected $title;

    /**
     * Build the table view with columns, rows, and other settings.
     *
     * @return Factory|View|void
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $columns = collect($this->columns())->filter(static fn (TD $column) => $column->isSee());

        $total = collect($this->total())->filter(static fn (TD $column) => $column->isSee());

        $content = $repository->getContent($this->target);

        $rows = is_a($content, Paginator::class) || is_a($content, CursorPaginator::class) ? $content : collect()->merge($content);

        return view($this->template, [
            'repository'     => $repository,
            'rows'           => $rows,
            'columns'        => $columns,
            'total'          => $total,
            'iconNotFound'   => $this->iconNotFound(),
            'textNotFound'   => $this->textNotFound(),
            'subNotFound'    => $this->subNotFound(),
            'actionNotFound' => $this->actionNotFound(),
            'striped'        => $this->striped,
            'compact'        => $this->compact,
            'bordered'       => $this->bordered,
            'hoverable'      => $this->hoverable,
            'slug'           => $this->getSlug(),
            'onEachSide'     => $this->onEachSide,
            'showHeader'     => $this->hasHeader($columns, $rows),
            'title'          => $this->title,
        ]);
    }

    /**
     * Set the table title.
     */
    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Determine whether the current request contains active filters.
     */
    protected function hasActiveFilters(): bool
    {
        return request()
            ->collect('filter')
            ->flatten()
            ->contains(static fn ($value) => filled($value));
    }

    /**
     * Usage for zebra-striping to any table row.
     */
    protected bool $striped = false;

    public function striped(): self
    {
        $this->striped = true;

        return $this;
    }

    /**
     * Usage for compact display of table rows.
     */
    protected bool $compact = false;

    public function compact(): self
    {
        $this->compact = true;

        return $this;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     */
    protected bool $bordered = false;

    public function bordered(): self
    {
        $this->bordered = true;

        return $this;
    }

    /**
     * Enable a hover state on table rows.
     */
    protected bool $hoverable = false;

    public function hoverable(): self
    {
        $this->hoverable = true;

        return $this;
    }

    /**
     * The number of links to display on each side of the current page link.
     */
    protected int $onEachSide = 3;

    public function onEachSide(int $count): self
    {
        $this->onEachSide = $count;

        return $this;
    }

    /**
     * Determine if table header should be displayed.
     */
    protected function hasHeader(Collection $columns, Collection|Paginator|CursorPaginator $row): bool
    {
        if ($columns->count() < 2) {
            return false;
        }

        return ! empty(request()->query()) || $row->isNotEmpty();
    }

    /**
     * Define table columns.
     *
     * @return iterable|TD[]
     */
    protected function columns(): iterable
    {
        return $this->columns;
    }

    /**
     * Define total row configuration.
     */
    protected array $totals = [];

    public function totals(array $columns): self
    {
        $this->totals = $columns;

        return $this;
    }

    protected function total(): array
    {
        return $this->totals;
    }
}
