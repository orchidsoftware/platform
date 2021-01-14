<?php

namespace Orchid\Metrics;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TimeCollection extends Collection
{
    /**
     * @param string        $name
     * @param \Closure|null $closure
     *
     * @return array
     */
    public function toChart(string $name, \Closure $closure = null): array
    {
        $closure = $closure ?? static function ($label) {
            return $label;
        };

        return [
            'name'   => $name,
            'labels' => $this->pluck('label')->map($closure)->toArray(),
            'values' => $this->pluck('value')->toArray(),
        ];
    }

    /**
     * @return TimeCollection
     */
    public function showDaysOfWeek(): TimeCollection
    {
        return $this->transform(function (array $value) {
            $day = Carbon::parse($value['label'])->dayName;

            $value['label'] = Str::ucfirst($day);

            return $value;
        });
    }
}
