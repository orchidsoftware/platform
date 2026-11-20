<?php

namespace Orchid\Metrics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @extends Collection<array-key, Model|array{label: mixed, value: int|float|numeric-string|null}>
 */
class GroupCollection extends Collection
{
    /**
     * Formats the collection data into a format that can be used in a chart.
     *
     * @param \Closure|null $closure The closure that formats the label. It receives a string and returns a string.
     *
     * @return array{labels: list<mixed>, datasets: list<array{values: list<int>}>}
     */
    public function toChart(?\Closure $closure = null): array
    {
        // If the closure is not set, we define a default one that returns the original label.
        $closure ??= static fn ($label) => $label;

        $groups = $this->sortByDesc('value');

        return [
            'labels'   => [...$groups->pluck('label')->map($closure)->values()],
            'datasets' => [[
                'values' => [...$groups->pluck('value')->map(fn ($value) => (int) $value)->values()],
            ]],
        ];
    }
}
