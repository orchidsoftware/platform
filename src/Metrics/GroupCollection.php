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
        $closure = $closure ?? static fn ($label) => $label;

        return $this
            ->sortByDesc('value')
            ->pluck('label')
            ->map(fn (string $name) => [
                'labels'  => $this->pluck('label')->map($closure)->toArray(),
                'values'  => $this->getChartsValues($name),
            ])
            ->toArray();
    }

    /**
     * Helper function for the toChart() method. It gets the chart values for a given label.
     *
     * @param string $name The label that we want to get the chart values for.
     *
     * @return array An array of values that will be used in the chart.
     */
    private function getChartsValues(string $name): array
    {
        return $this
            ->map(static fn ($item) => $item->label === $name ? (int) $item->value : 0)
            ->toArray();
    }
}
