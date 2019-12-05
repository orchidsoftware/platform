<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

/**
 * Class TestConsoleCase.
 */
abstract class TestConsoleCase extends TestCase
{
    use Environment;

    /**
     * @return string
     */
    public function generateNameFromMethod(): string
    {
        return Str::studly(debug_backtrace()[1]['function'].Str::random());
    }

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
