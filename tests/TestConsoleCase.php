<?php

declare(strict_types=1);

namespace Orchid\Tests;

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
        return studly_case(debug_backtrace()[1]['function'] . str_random());
    }
}
