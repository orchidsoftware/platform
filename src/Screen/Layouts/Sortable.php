<?php

namespace Orchid\Screen\Layouts;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Orchid\Screen\Concerns\HasEmptyState;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;

/** @phpstan-consistent-constructor */
class Sortable extends Layout
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
     */
    protected bool $showBlockHeaders = false;

    /**
     * @return Factory|View|null
     */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return null;
        }

        $columns = collect($this->columns())->filter(static fn (Sight $sight) => $sight->isSee());

        $rows = collect()->merge($repository->getContent($this->target));

        return view($this->template, [
            'rows'               => $rows,
            'columns'            => $columns,
            'slug'               => $this->getSlug(),
            'title'              => $this->title,
            'showBlockHeaders'   => $this->showBlockHeaders,
            'iconNotFound'       => $this->iconNotFound(),
            'textNotFound'       => $this->textNotFound(),
            'subNotFound'        => $this->subNotFound(),
            'actionNotFound'     => $this->actionNotFound(),
            'successSortMessage' => $this->successSortMessage(),
            'failureSortMessage' => $this->failureSortMessage(),
        ]);
    }

    /**
     * @return array
     */
    protected function columns(): iterable
    {
        return $this->columns;
    }

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

    protected ?string $successMessage = null;

    protected ?string $failureMessage = null;

    public function successMessage(string $message): self
    {
        $this->successMessage = $message;

        return $this;
    }

    public function failureMessage(string $message): self
    {
        $this->failureMessage = $message;

        return $this;
    }

    /**
     * Return a success message for sorting operation.
     */
    public function successSortMessage(): string
    {
        return $this->successMessage ?? __('Sorting was successful.');
    }

    /**
     * Return a failure message for sorting operation.
     */
    public function failureSortMessage(): string
    {
        return $this->failureMessage ?? __('Sorting failed. Please try again.');
    }
}
