<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @method        literal-string|null getCreatedAtColumn()
 * @method static GroupCollection     countForGroup(string $groupColumn)
 * @method static TimeCollection      countByDays(string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string|null $dateColumn = null)
 * @method static TimeCollection      averageByDays(literal-string $value, string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string|null $dateColumn = null)
 * @method static TimeCollection      sumByDays(literal-string $value, string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string|null $dateColumn = null)
 * @method static TimeCollection      maxByDays(literal-string $value, string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string|null $dateColumn = null)
 * @method static TimeCollection      minByDays(literal-string $value, string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string|null $dateColumn = null)
 * @method static TimeCollection      valuesByDays(literal-string $value, string|DateTimeInterface|null $startDate = null, string|DateTimeInterface|null $stopDate = null, literal-string $dateColumn = 'created_at')
 */
trait Chartable
{
    /**
     * Counts the values for model at the range and previous range.
     *
     * @param Builder<static> $builder
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
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
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

        $values = $builder
            ->select(DB::raw("$value as value, DATE($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->pluck('value', 'label');

        $days = $startDate->startOfDay()->daysUntil($stopDate->startOfDay());

        return TimeCollection::make($days->map(function (Carbon $day) use ($values) {
            $label = $day->toDateString();

            return [
                'value' => $values->get($label, 0),
                'label' => $label,
            ];
        }));
    }

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param Builder<static>               $builder
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
     */
    #[Scope]
    protected function countByDays(Builder $builder, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, 'count(*)', $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get average models grouped by `created_at` day.
     *
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
     */
    #[Scope]
    protected function averageByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "avg($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
     */
    #[Scope]
    protected function sumByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
     */
    #[Scope]
    protected function maxByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "max($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get min models grouped by `created_at` day.
     *
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string|null           $dateColumn
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
     * @param Builder<static>               $builder
     * @param literal-string                $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param literal-string                $dateColumn
     */
    #[Scope]
    protected function valuesByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, $value, $startDate, $stopDate, $dateColumn);
    }
}
