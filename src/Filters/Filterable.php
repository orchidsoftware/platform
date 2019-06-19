<?php

declare(strict_types=1);

namespace Orchid\Filters;

use Illuminate\Support\Collection;
use Orchid\Screen\Layouts\Selection;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $query
     * @param array   $filters
     *
     * @return Builder
     */
    public function scopeFiltersApply(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $filter) {
            if (! is_object($filter)) {
                $filter = app()->make($filter);
            }

            $query = $filter->filter($query);
        }

        return $query;
    }

    /**
     * @param Builder          $query
     * @param string|Selection $selection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Builder
     */
    public function scopeFiltersApplySelection(Builder $query, $selection)
    {
        if (! is_object($selection)) {
            $selection = app()->make($selection);
        }

        $filters = $selection->filters();

        return $this->scopeFiltersApply($query, $filters);
    }

    /**
     * @param Builder         $builder
     * @param HttpFilter|null $httpFilter
     *
     * @return Builder
     */
    public function scopeFilters(Builder $builder, HttpFilter $httpFilter = null)
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
