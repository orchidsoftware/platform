<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TimeCollection extends Collection
{
    public function toChart(string $name, \Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        return [
            'name'   => $name,
            'labels' => $this->pluck('label')->map($closure)->toArray(),
            'values' => $this->pluck('value')->toArray(),
        ];
    }

    public function showDaysOfWeek(): TimeCollection
    {
        return $this->transformLabel(function (array $value) {
            $day = Carbon::parse($value['label'])->dayName;

            return Str::ucfirst($day);
        });
    }

    public function showMinDaysOfWeek(): TimeCollection
    {
        return $this->transformLabel(function (array $value) {
            $day = Carbon::parse($value['label'])->minDayName;

            return Str::ucfirst($day);
        });
    }

    /**
     * @return TimeCollection
     */
    public function transformLabel(callable $callback)
    {
        return $this->transform(function (array $value) use ($callback) {
            $value['label'] = $callback($value);

            return $value;
        });
    }
}
