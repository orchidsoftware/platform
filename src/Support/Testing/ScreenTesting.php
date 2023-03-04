<?php

namespace Orchid\Support\Testing;

trait ScreenTesting
{
    /**
     * @param string $name
     */
    public function screen(string $name = null): DynamicTestScreen
    {
        return new DynamicTestScreen($name);
    }
}
