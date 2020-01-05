<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchestra\Testbench\TestCase;

class Bootstrap extends TestCase
{
    use Environment;

    /**
     * Performs initial installation before running tests.
     */
    public function testInstallPackage(): void
    {
        $this->artisan('orchid:install');
        $this->assertTrue(true);
    }
}
