<?php

namespace Orchid\Metrics;

use Illuminate\Support\Collection;

class GroupCollection extends Collection
{
    /**
     * Formats the collection data into a format that can be used in a chart.
     *
     * @param \Closure|null $closure The closure that formats the label. It receives a string and returns a string.
     *
     * @return array A multidimensional array ready to be used in a chart.
     */
    public function toChart(?\Closure $closure = null): array
    {
        // If the closure is not set, we define a default one that returns the original label.
        $closure ??= static fn ($label) => $label;

        $groups = $this->sortByDesc('value')->values();

        return [
            'labels'   => $groups->pluck('label')->map($closure)->all(),
            'datasets' => [[
                'values' => $groups->pluck('value')->map(fn ($value) => (int) $value)->all(),
            ]],
        ];
    }
}
