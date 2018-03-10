<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Filters\Filter;

trait FilterTrait
{

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFilters(Builder $builder)
    {
        $filter = new Filter;
        $filter->build($builder);

        return $builder;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptionsFilter()
    {
        return collect([
            'allowedFilters'   => collect($this->allowedFilters ?? []),
            'allowedSorts'     => collect($this->allowedSorts ?? []),
            'allowedIncludes'  => collect($this->allowedIncludes ?? []),
        ]);
    }


    /**
     * @param Builder $query
     * @param array   $filters
     *
     * @return Builder
     */
    public function scopeFiltersApply(Builder $query, $filters = []): Builder
    {
        return $query;

        /*
        foreach ($filters as $filter) {
            if (!is_object($filter)) {
                $filter = app()->make($filter);
            }

            $query = $filter->filter($query);
        }

        return $query;
        */
    }
}
