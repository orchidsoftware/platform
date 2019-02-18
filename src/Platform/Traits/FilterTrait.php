<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Illuminate\Support\Collection;
use Orchid\Platform\Filters\HttpFilter;
use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    /**
     * @param Builder $query
     * @param array $filters
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
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeFilters(Builder $builder)
    {
        $filter = new HttpFilter;
        $filter->build($builder);

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $direction
     *
     * @return Builder
     */
    public function scopeDefaultSort(Builder $builder, string $column, string $direction = 'asc')
    {
        if (is_null($builder->getQuery()->orders)) {
            $builder->orderBy($column, $direction);
        }

        return $builder;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptionsFilter(): Collection
    {
        return collect([
            'allowedFilters' => collect($this->allowedFilters ?? []),
            'allowedSorts'   => collect($this->allowedSorts ?? []),
        ]);
    }
}
