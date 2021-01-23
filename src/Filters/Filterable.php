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
     *
     * @param Builder $query
     * @param array   $filters
     *
     * @return Builder
     */
    public function scopeFiltersApply(Builder $query, array $filters = []): Builder
    {
        return collect($filters)
            ->map(function ($filter) {
                return is_object($filter) ? $filter : resolve($filter);
            })
            ->reduce(function (Builder $query, Filter $filter) {
                return $filter->filter($query);
            }, $query);
    }

    /**
     * Apply the filter to the given selection.
     *
     * @param Builder          $query
     * @param string|Selection $selection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Builder
     */
    public function scopeFiltersApplySelection(Builder $query, $selection): Builder
    {
        /** @var Selection $selection */
        $selection = is_object($selection) ? $selection : resolve($selection);

        $filters = $selection->filters();

        return $this->scopeFiltersApply($query, $filters);
    }

    /**
     * @param Builder         $builder
     * @param HttpFilter|null $httpFilter
     *
     * @return Builder
     */
    public function scopeFilters(Builder $builder, HttpFilter $httpFilter = null): Builder
    {
        $filter = $httpFilter ?? new HttpFilter();
        $filter->build($builder);

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string  $column
     * @param string  $direction
     *
     * @return Builder
     */
    public function scopeDefaultSort(Builder $builder, string $column, string $direction = 'asc')
    {
        if (empty($builder->getQuery()->orders)) {
            $builder->orderBy($column, $direction);
        }

        return $builder;
    }

    /**
     * @return Collection
     */
    public function getOptionsFilter(): Collection
    {
        return collect([
            'allowedFilters' => collect($this->allowedFilters ?? []),
            'allowedSorts'   => collect($this->allowedSorts ?? []),
        ]);
    }
}
