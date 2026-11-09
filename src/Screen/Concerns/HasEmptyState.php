<?php

declare(strict_types=1);

namespace Orchid\Screen\Concerns;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;

trait HasEmptyState
{
    protected array $emptyState = [];

    public function emptyTitle(string $title): self
    {
        $this->emptyState['title'] = $title;

        return $this;
    }

    public function emptyDescription(string $description): self
    {
        $this->emptyState['description'] = $description;

        return $this;
    }

    public function emptyIcon(string $icon): self
    {
        $this->emptyState['icon'] = $icon;

        return $this;
    }

    public function emptyAction(?Action $action): self
    {
        $this->emptyState['action'] = $action;

        return $this;
    }

    /**
     * Icon displayed when no data is found.
     */
    protected function iconNotFound(): string
    {
        return $this->emptyState['icon'] ?? 'bs.journal-x';
    }

    /**
     * Text displayed when no data is found.
     */
    protected function textNotFound(): string
    {
        return $this->emptyState['title'] ?? ($this->hasActiveFilters()
            ? __('No matches')
            : __('No items yet'));
    }

    /**
     * Subtext displayed when no data is found.
     */
    protected function subNotFound(): string
    {
        return $this->emptyState['description'] ?? ($this->hasActiveFilters()
            ? __('Try changing or clearing the filters.')
            : __('New items will appear here.'));
    }

    /**
     * Action displayed when no data is found.
     */
    protected function actionNotFound(): ?Action
    {
        if (array_key_exists('action', $this->emptyState)) {
            return $this->emptyState['action'];
        }

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
