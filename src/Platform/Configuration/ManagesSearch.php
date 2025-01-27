<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Collection;

trait ManagesSearch
{
    /**
     * Registers a set of models for which full-text search is required.
     *
     * @return $this
     */
    public function registerSearch(array $models): static
    {
        static::$options['search'] = array_merge($models, static::$options['search'] ?? []);

        return $this;
    }

    /**
     * Get the list of searchable models, ensuring uniqueness and resolving model instances.
     *
     * @return Collection The collection of searchable models.
     */
    public function getSearch(): Collection
    {
        return collect(static::$options['search'])
            ->unique()
            ->transform(static fn ($model) => is_object($model) ? $model : resolve($model));
    }
}
