<?php

namespace Orchid\Metrics;

use Illuminate\Support\Collection;

class GroupCollection extends Collection
{
    /**
     * @param \Closure|null $closure
     *
     * @return array
     */
    public function toChart(\Closure $closure = null): array
    {
        $closure = $closure ?? static fn ($label) => $label;

        return $this
            ->sortByDesc('value')
            ->pluck('label')
            ->map(fn (string $name) => [
                'labels' => $this->pluck('label')->map($closure)->toArray(),
                'values' => $this->getChartsValues($name),
            ])
            ->toArray();
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function getChartsValues(string $name): array
    {
        return $this
            ->map(static fn ($item) => $item->label === $name ? (int) $item->value : 0)
            ->toArray();
    }
}
