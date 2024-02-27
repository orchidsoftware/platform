<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TimeCollection extends Collection
{
    /**
     * @param        $values
     * @param string $format
     *
     * @return \Orchid\Metrics\TimeCollection
     */
    public function makeFromKeyValue($values, string $format = 'Y-m-d'): TimeCollection
    {
        $prepare = collect($values)->map(fn ($value, $key) => [
            'label' => Carbon::parse($key)->format($format),
            'value' => round($value),
        ]);

        return static::make($prepare);
    }

    /**
     * Convert to a format suitable for a chart
     *
     * @param string   $name
     * @param \Closure $closure
     *
     * @return array
     */
    public function toChart(string $name, ?\Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        return [
            'name'    => $name,
            'labels'  => $this->pluck('label')->map($closure)->toArray(),
            'values'  => $this->pluck('value')->toArray(),
        ];
    }

    /**
     * Convert collection data to day names
     *
     * @return TimeCollection
     */
    public function showDaysOfWeek(): TimeCollection
    {
        return $this->transformLabel(function (array $value) {
            $day = Carbon::parse($value['label'])->dayName;

            return Str::ucfirst($day);
        });
    }

    /**
     * Convert collection data to abbreviated day names
     *
     * @return TimeCollection
     */
    public function showMinDaysOfWeek(): TimeCollection
    {
        return $this->transformLabel(function (array $value) {
            $day = Carbon::parse($value['label'])->minDayName;

            return Str::ucfirst($day);
        });
    }

    /**
     * Transform the labels using the provided callback
     *
     * @param callable $callback
     *
     * @return TimeCollection
     */
    public function transformLabel(callable $callback): TimeCollection
    {
        return $this->transform(function (array $value) use ($callback) {
            $value['label'] = $callback($value);

            return $value;
        });
    }

    /**
     * Delete segment if at least one of the values is missing.
     *
     * @return TimeCollection
     */
    public function withoutZeroValues(): TimeCollection
    {
        return $this->filter(function (array $item) {
            return $item['value'] !== 0;
        });
    }
}
