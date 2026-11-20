<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Screen\Concerns\HasEmptyState;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

/**
 * Class Table.
 */
abstract class Table extends Layout
{
    use HasEmptyState;

    protected $template = 'orchid::layouts.table';

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target;

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
     * @return View|null
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
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
            'striped'        => $this->striped(),
            'compact'        => $this->compact(),
            'bordered'       => $this->bordered(),
            'hoverable'      => $this->hoverable(),
            'slug'           => $this->getSlug(),
            'onEachSide'     => $this->onEachSide(),
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
    protected function striped(): bool
    {
        return false;
    }

    /**
     * Usage for compact display of table rows.
     */
    protected function compact(): bool
    {
        return false;
    }

    /**
     * Usage for borders on all sides of the table and cells.
     */
    protected function bordered(): bool
    {
        return false;
    }

    /**
     * Enable a hover state on table rows.
     */
    protected function hoverable(): bool
    {
        return false;
    }

    /**
     * The number of links to display on each side of the current page link.
     */
    protected function onEachSide(): int
    {
        return 3;
    }

    /**
     * Determine if table header should be displayed.
     *
     * @param Collection<array-key, TD>                                                                  $columns
     * @param Collection<array-key, mixed>|Paginator<array-key, mixed>|CursorPaginator<array-key, mixed> $row
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
     * @return TD[]|\Traversable<array-key, TD>
     */
    abstract protected function columns(): iterable;

    /**
     * Define total row configuration.
     *
     * @return array<TD>
     */
    protected function total(): array
    {
        return [];
    }
}
