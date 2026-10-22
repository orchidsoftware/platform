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

    protected function hasActiveFilters(): bool
    {
        return false;
    }
}
