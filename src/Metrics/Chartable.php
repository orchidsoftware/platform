<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
            ->get()
            ->map(function (Model $model) {
                return $model->forceFill([
                    'label' => (string) $model->label,
                    'value' => (int) $model->value,
                ]);
            });

        return new GroupCollection($group);
    }

    /**
     * @param Builder    $builder
     * @param string     $value
     * @param mixed|null $startDate
     * @param mixed|null $stopDate
     * @param string     $dateColumn
     *
     * @return TimeCollection
     */
    private function groupByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
    {
        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()
            : Carbon::parse($stopDate);

        $query = $builder->select(
            DB::raw("$value as value"),
            DB::raw("DATE($dateColumn) as label")
        )
            ->where($dateColumn, '>=', $startDate)
            ->where($dateColumn, '<=', $stopDate)
            ->orderBy('label')
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

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeCountByDays(Builder $builder, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, 'count(*)', $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get values models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeValuesByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, $value, $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum values models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeSumByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, "SUM($value)", $startDate, $stopDate, $dateColumn);
    }
}
