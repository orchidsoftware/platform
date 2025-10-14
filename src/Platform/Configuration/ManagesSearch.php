<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Orchid\Screen\Contracts\Searchable;

trait ManagesSearch
{
    /**
     * A registry of all registered permissions, grouped by category.
     *
     * @var array<string, array<string, mixed>>
     */
    protected static array $registeredSearchModels = [];

    /**
     * Registers a set of models for which full-text search is required.
     *
     * @param array $models
     *
     * @return static
     */
    public function registerSearch(array $models): static
    {
        static::$registeredSearchModels = array_merge(static::$registeredSearchModels, $models);

        return $this;
    }

    /**
     * Get the list of searchable models, ensuring uniqueness and resolving model instances.
     *
     * @return Collection The collection of searchable models.
     */
    public function getSearch(): Collection
    {
        return collect(static::$registeredSearchModels)
            ->unique()
            ->transform(static fn ($model) => is_object($model) ? $model : resolve($model));
    }

    /**
     * Execute a search across all registered models and return grouped results.
     */
    public function search(?string $query = null): Collection
    {
        return $this->getSearch()
            ->map(fn (Model $model) => $this->buildSearchResult($model, $query))
            ->filter();
    }

    /**
     * Build a single search result group for the given model.
     *
     * @param Model $model
     * @param string|null $query
     * @return array{label: string,result: LengthAwarePaginator }|null
     * @throws \Throwable
     */
    protected function buildSearchResult(Model $model, ?string $query): ?array
    {
        $presenter = optional($model)->presenter();

        throw_unless(
            $presenter instanceof Searchable,
            sprintf(
                "The presenter must implement '%s' for model %s.",
                Searchable::class,
                get_class($model)
            )
        );

        $result = $presenter->searchQuery($query)
            ->paginate($presenter->perSearchShow());

        if ($result->isEmpty()) {
            return null;
        }

        $result->getCollection()
            ->transform(static fn (Model $model) => $model->presenter());

        return [
            'label'  => $presenter->label(),
            'result' => $result,
        ];
    }
}
