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
}
