<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Illuminate\Testing\PendingCommand;
use Orchestra\Testbench\TestCase;

/**
 * @method PendingCommand artisan(string $command, array<string, mixed> $parameters = [])
 */
abstract class TestConsoleCase extends TestCase
{
    use Environment;
}
