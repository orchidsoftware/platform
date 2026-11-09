<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait Chartable
{
    /**
     * Counts the values for model at the range and previous range.
     */
    #[Scope]
    protected function countForGroup(Builder $builder, string $groupColumn): GroupCollection
    {
        $group = $builder->select("$groupColumn as label", DB::raw('count(*) as value'))
            ->groupBy($groupColumn)
            ->orderBy('value', 'desc')
            ->get()
            ->map(fn (Model $model) => $model->forceFill([
                'label' => (string) $model->getAttribute('label'),
                'value' => (int) $model->getAttribute('value'),
            ]));

        return new GroupCollection($group);
    }

    /**
     * @param mixed|null $startDate
     * @param mixed|null $stopDate
     * @param string     $dateColumn
     */
    private function groupByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        $dateColumn ??= $builder->getModel()->getCreatedAtColumn();

        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()
            : Carbon::parse($stopDate);

        $query = $builder
            ->select(DB::raw("$value as value, DATE($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = $startDate->diffInDays($stopDate) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->toDateString()
            );

            $result = [
                'value'   => ($found ? $found->getAttribute('value') : 0),
                'label'   => $startDate->toDateString(),
            ];

            $startDate->addDay();

            return $result;
        });
    }

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     */
    #[Scope]
    protected function countByDays(Builder $builder, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, 'count(*)', $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get average models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    #[Scope]
    protected function averageByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "avg($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    #[Scope]
    protected function sumByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    #[Scope]
    protected function maxByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "max($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get min models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    #[Scope]
    protected function minByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "min($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * @deprecated usage maxByDays or minByDays
     *
     * Get values models grouped by `created_at` day.
     *
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     */
    #[Scope]
    protected function valuesByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, $value, $startDate, $stopDate, $dateColumn);
    }
}
