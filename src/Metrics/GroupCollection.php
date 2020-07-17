<?php

namespace Orchid\Metrics;

use Illuminate\Support\Collection;

class GroupCollection extends Collection
{
    /**
     * @return array
     */
    public function toChart(): array
    {
        return $this
            ->pluck('label')
            ->map(function (string $name) {
                return [
                    'labels' => $this->pluck('label')->toArray(),
                    'name'   => $name,
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
