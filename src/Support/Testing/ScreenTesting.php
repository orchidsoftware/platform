<?php

namespace Orchid\Support\Testing;

trait ScreenTesting
{
    /**
     * Get a DynamicTestScreen object.
     *
     * @param string|null             $name       Name of the screen
     * @param array<array-key, mixed> $parameters
     */
    public function screen(?string $name = null, array $parameters = []): DynamicTestScreen
    {
        return (new DynamicTestScreen($name))
            ->parameters($parameters);
    }
}
