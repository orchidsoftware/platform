<?php

namespace Orchid\Tests;

use Orchestra\Testbench\Dusk\TestCase;

abstract class TestBrowserCase extends TestCase
{
    use Environment;

    public static function setUpBeforeClass()
    {
        static::serve();
    }

    public static function tearDownAfterClass()
    {
        static::stopServing();
    }
}
