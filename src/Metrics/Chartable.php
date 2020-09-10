<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait Chartable
{
    /**
     * Counts the values for model at the range and previous range.
     *
     * @param Builder $builder
     * @param string  $groupColumn
     *
     * @return GroupCollection
     */
    public function scopeCountForGroup(Builder $builder, string $groupColumn): GroupCollection
    {
        $group = $builder->select("$groupColumn as label", DB::raw('count(*) as value'))
            ->groupBy($groupColumn)
            ->orderBy('value', 'desc')
            ->get();

        return new GroupCollection($group);
    }

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param Builder                        $builder
     * @param string|\DateTimeInterface|null $startDate
     * @param string|\DateTimeInterface|null $stopDate
     * @param string                         $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeCountByDays(Builder $builder, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()
            : Carbon::parse($stopDate);

        $query = $builder->select(
            DB::raw('count(*) as value'),
            DB::raw("DATE($dateColumn) as label")
        )
            ->where($dateColumn, '>=', $startDate)
            ->where($dateColumn, '<=', $stopDate)
            ->orderBy('label', 'asc')
            ->groupBy('label')
            ->get();

        $days = $startDate->diffInDays($stopDate) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->toDateString()
            );

            $result = [
                'value' => ($found ? $found->value : 0),
                'label' => $startDate->toDateString(),
            ];

            $startDate->addDay();

            return $result;
        });
    }
}
