<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchestra\Testbench\TestCase;

/**
 * Class TestUnitCase.
 */
abstract class TestUnitCase extends TestCase
{
    use Environment;


    /**
     * Make sure all integration tests use the same Laravel "skeleton" files.
     * This avoids duplicate classes during migrations.
     *
     * Overrides \Orchestra\Testbench\Dusk\TestCase::getBasePath
     *       and \Orchestra\Testbench\Concerns\CreatesApplication::getBasePath
     *
     * @return string
     */
    protected function getBasePath()
    {
        // Adjust this path depending on where your override is located.
        return __DIR__.'/../vendor/orchestra/testbench-dusk/laravel';
    }
}
