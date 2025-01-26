<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Orchid\Screen\Layouts\Selection;

trait Filterable
{
    /**
     * Apply the filter to the given query.
     */
    public function scopeFiltersApply(Builder $query, iterable $filters = []): Builder
    {
        return collect($filters)
            ->map(fn ($filter) => is_object($filter) ? $filter : resolve($filter))
            ->reduce(fn (Builder $query, Filter $filter) => $filter->filter($query), $query);
    }

    /**
     * Apply the filter to the given selection.
     *
     * @param string|Selection $class
     */
    public function scopeFiltersApplySelection(Builder $query, $class): Builder
    {
        /** @var Selection $selection */
        $selection = is_object($class) ? $class : resolve($class);

        $filters = $selection->filters();

        return $this->scopeFiltersApply($query, $filters);
    }

    /**
     * @param iterable|string|Selection $kit
     */
    public function scopeFilters(Builder $builder, mixed $kit = null, ?HttpFilter $httpFilter = null): Builder
    {
        $filter = $httpFilter ?? new HttpFilter;
        $filter->build($builder);

        if ($kit === null) {
            return $builder;
        }

        return is_iterable($kit)
            ? $this->scopeFiltersApply($builder, $kit)
            : $this->scopeFiltersApplySelection($builder, $kit);
    }

    /**
     * @return Builder
     */
    public function scopeDefaultSort(Builder $builder, string $column, string $direction = 'asc')
    {
        if (empty($builder->getQuery()->orders)) {
            $builder->orderBy($column, $direction);
        }

        return $builder;
    }

    public function getOptionsFilter(): Collection
    {
        return collect([
            'allowedFilters' => collect($this->allowedFilters ?? []),
            'allowedSorts'   => collect($this->allowedSorts ?? []),
        ]);
    }
}
