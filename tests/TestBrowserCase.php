<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchestra\Testbench\Dusk\TestCase;

/**
 * Class TestBrowserCase.
 */
abstract class TestBrowserCase extends TestCase
{
    use Environment;

    /**
     * The base serve host URL to use while testing the application.
     *
     * @var string
     */
    protected static $baseServeHost = '127.0.0.1';

    /**
     * The base serve port to use while testing the application.
     *
     * @var int
     */
    protected static $baseServePort = 8000;

    /**
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    public static function setUpBeforeClass()
    {
        // To hide the UI during testing
        \Orchestra\Testbench\Dusk\Options::withoutUI();
        parent::setUpBeforeClass();
    }
}
