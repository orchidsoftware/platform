<?php

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Concerns\HasEmptyState;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;

abstract class Sortable extends Layout
{
    use HasEmptyState;

    /**
     * @var string
     */
    protected $template = 'orchid::layouts.sortable';

    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * @var Repository
     */
    protected $query;

    /**
     * Flag indicating whether block headers are hidden or shown.
     *
     * @var bool
     */
    protected bool $showBlockHeaders = false;

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
     * @return Factory|View|null
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $columns = collect($this->columns())->filter(static fn (Sight $sight) => $sight->isSee());

        $rows = collect()->merge($repository->getContent($this->target));

        return view($this->template, [
            'rows'                  => $rows,
            'columns'               => $columns,
            'slug'                  => $this->getSlug(),
            'title'                 => $this->title,
            'showBlockHeaders'      => $this->showBlockHeaders,
            'emptyStateIcon'        => $this->emptyStateIcon(),
            'emptyStateTitle'       => $this->emptyStateTitle(),
            'emptyStateDescription' => $this->emptyStateDescription(),
            'emptyStateAction'      => $this->emptyStateAction(),
            'successSortMessage'    => $this->successSortMessage(),
            'failureSortMessage'    => $this->failureSortMessage(),
        ]);
    }

    /**
     * @return array
     */
    abstract protected function columns(): iterable;

    /**
     * @return Rows
     */
    public function title(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Show or hide block headers.
     *
     * @param bool $showHeaders Whether to show block headers or not. Default is false.
     *
     * @return $this
     */
    public function showBlockHeaders(bool $showHeaders = true): self
    {
        $this->showBlockHeaders = $showHeaders;

        return $this;
    }

    /**
     * Return a success message for sorting operation.
     *
     * @return string
     */
    public function successSortMessage(): string
    {
        return __('Sorting was successful.');
    }

    /**
     * Return a failure message for sorting operation.
     *
     * @return string
     */
    public function failureSortMessage(): string
    {
        return __('Sorting failed. Please try again.');
    }
}
