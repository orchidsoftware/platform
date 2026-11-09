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

    protected function firstElement(\DOMXPath $xpath, string $expression): \DOMElement
    {
        $nodes = $xpath->query($expression);
        $this->assertNotFalse($nodes);
        $element = $nodes->item(0);
        $this->assertInstanceOf(\DOMElement::class, $element);

        return $element;
    }
}
