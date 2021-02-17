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
        $closure = $closure ?? static function ($label) {
            return $label;
        };

        return $this
            ->sortByDesc('value')
            ->pluck('label')
            ->map(function (string $name) use ($closure) {
                return [
                    'labels' => $this->pluck('label')->map($closure)->toArray(),
                    'values' => $this->getChartsValues($name),
                ];
            })
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
            ->map(static function ($item) use ($name) {
                return $item->label === $name
                    ? (int) $item->value
                    : 0;
            })
            ->toArray();
    }
}
