<?php

declare(strict_types=1);

namespace Orchid\Platform\Core\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    /**
     * @param Builder $query
     * @param array   $filters
     *
     * @return Builder
     */
    public function scopeFiltersApply(Builder $query, $filters = []) : Builder
    {
        foreach ($filters as $filter) {
            if (! is_object($filter)) {
                $filter = app()->make($filter);
            }

            $query = $filter->filter($query);
        }

        return $query;
    }
}
