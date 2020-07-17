<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait Chartable
{
    /**
     * Counts the values for model at the range and previous range
     *
     * @param Builder $builder
     * @param string  $groupColumn
     * @param string  $dateColumn
     *
     * @return GroupCollection
     */
    public function scopeCountForGroup(Builder $builder, string $groupColumn, string $dateColumn = 'created_at')
    {
        $group = $builder->select("$groupColumn as label", DB::raw('count(*) as value'))
            ->groupBy($groupColumn)
            ->orderBy($dateColumn, 'asc')
            ->get();

        return new GroupCollection($group);
    }

    /**
     * Get total models grouped by `created_at` day
     *
     * @param Builder $builder
     * @param string  $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeCountByDays(Builder $builder, $dateColumn = 'created_at')
    {
        $startDate = Carbon::now()->subMonth();
        $stopDate = Carbon::now();

        $query = $builder->select(
            DB::raw('count(*) as value, count(*) as label'),
            DB::raw("DATE($dateColumn) as date")
        )
            ->where($dateColumn, '>=', $startDate)
            ->where($dateColumn, '<=', $stopDate)
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $days = $startDate->diffInDays($stopDate) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {

            $found = $query->firstWhere(
                'date',
                $startDate->startOfDay()->toDateString()
            );

            $result = [
                'date'  => $startDate->toDateString(),
                'value' => (int)($found ? $found->value : 0),
                'label' => $found ? $found->value : 0,
            ];

            $startDate->addDay();

            return $result;
        });
    }
}
