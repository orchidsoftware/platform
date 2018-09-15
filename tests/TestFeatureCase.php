<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchestra\Testbench\TestCase;

/**
 * Class TestUnitCase.
 */
abstract class TestFeatureCase extends TestCase
{
    use Environment;
}
