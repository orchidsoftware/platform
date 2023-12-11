<?php

namespace Orchid\Support\Testing;

trait ScreenTesting
{
    /**
     * Get a DynamicTestScreen object.
     *
     * @param string|null $name Name of the screen
     *
     * @return \Orchid\Support\Testing\DynamicTestScreen
     */
    public function screen(?string $name = null): DynamicTestScreen
    {
        return new DynamicTestScreen($name);
    }
}
