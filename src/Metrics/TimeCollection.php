<?php

namespace Orchid\Metrics;

class TimeCollection extends Chartable
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function toChart(string $name): array
    {
        return [
            'name'   => $name,
            'labels' => $this->pluck('date')->toArray(),
            'values' => $this->pluck('value')->toArray(),
        ];
    }
}
