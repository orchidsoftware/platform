<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

/**
 * Class Table.
 */
abstract class Table extends Layout
{
    /**
     * @var string
     */
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
     *
     * @param string|null $title
     *
     * @return self
     */
    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Icon displayed when no data is found.
     */
    protected function iconNotFound(): string
    {
        return 'bs.journal-x';
    }

    /**
     * Text displayed when no data is found.
     */
    protected function textNotFound(): string
    {
        return $this->hasActiveFilters()
            ? __('No matches')
            : __('No items yet');
    }

    /**
     * Subtext displayed when no data is found.
     */
    protected function subNotFound(): string
    {
        return $this->hasActiveFilters()
            ? __('Try changing or clearing the filters.')
            : __('New items will appear here.');
    }

    /**
     * Action displayed when no data is found.
     */
    protected function actionNotFound(): ?Action
    {
        if (! $this->hasActiveFilters()) {
            return null;
        }

        return Link::make('Clear filters')
            ->icon('bs.arrow-counterclockwise')
            ->href(request()->fullUrlWithoutQuery(['filter', 'page', 'cursor']))
            ->class('btn btn-link d-inline-flex gap-2 text-decoration-none');
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
     * @param Collection                           $columns
     * @param Collection|Paginator|CursorPaginator $row
     *
     * @return bool
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
    abstract protected function columns(): iterable;

    /**
     * Define total row configuration.
     */
    protected function total(): array
    {
        return [];
    }
}
