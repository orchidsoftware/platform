<?php

namespace Orchid\Metrics;

use Illuminate\Support\Collection;

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
}
