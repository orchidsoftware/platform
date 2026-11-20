<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @extends Collection<array-key, array{label: string, value: int|float|numeric-string|null}>
 */
class TimeCollection extends Collection
{
    /**
     * @param iterable<array-key, int|float|numeric-string> $values
     */
    public function makeFromKeyValue($values, string $format = 'Y-m-d'): TimeCollection
    {
        $prepare = collect($values)->map(fn ($value, $key) => [
            'label' => Carbon::parse($key)->format($format),
            'value' => round((float) $value),
        ]);

        return static::make($prepare);
    }

    /**
     * Convert to a format suitable for a chart
     *
     * @return array{labels: list<mixed>, datasets: list<array{name: string, values: list<int|float|numeric-string|null>}>}
     */
    public function toChart(string $name, ?\Closure $closure = null): array
    {
        $closure ??= static fn ($label) => $label;

        return [
            'labels'   => [...$this->pluck('label')->map($closure)->values()],
            'datasets' => [[
                'name'   => $name,
                'values' => [...$this->pluck('value')->values()],
            ]],
        ];
    }

    /**
     * Convert collection data to day names
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
     */
    public function withoutZeroValues(): TimeCollection
    {
        return $this->filter(fn (array $item) => $item['value'] !== 0);
    }
}
