<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;

trait HasEmptyState
{
    /**
     * Icon displayed when no data is found.
     */
    protected function emptyStateIcon(): string
    {
        return 'bs.journal-x';
    }

    /**
     * Title displayed when no data is found.
     *
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress NullableReturnStatement
     */
    protected function emptyStateTitle(): string
    {
        return $this->hasActiveFilters()
            ? __('No matches')
            : __('No items yet');
    }

    /**
     * Description displayed when no data is found.
     *
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress NullableReturnStatement
     */
    protected function emptyStateDescription(): string
    {
        return $this->hasActiveFilters()
            ? __('Try changing or clearing the filters.')
            : __('New items will appear here.');
    }

    /**
     * Action displayed when no data is found.
     */
    protected function emptyStateAction(): ?Action
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
}
