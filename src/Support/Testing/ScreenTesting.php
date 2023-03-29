<?php

namespace Orchid\Support\Testing;

trait ScreenTesting
{
    /**
     * @param string|null $name
     *
     * @return \Orchid\Support\Testing\DynamicTestScreen
     */
    public function screen(string $name = null): DynamicTestScreen
    {
        return new DynamicTestScreen($name);
    }
}
