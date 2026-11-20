<?php

declare(strict_types=1);

namespace Orchid\Tests;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Illuminate\Support\Collection;
use Orchestra\Testbench\TestCase;

/**
 * Class TestUnitCase.
 */
abstract class TestUnitCase extends TestCase
{
    use Environment;

    protected function xpath(string $html): DOMXPath
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return new DOMXPath($document);
    }

    /** @return Collection<int, DOMElement> */
    protected function elements(DOMXPath $xpath, string $expression, ?DOMNode $context = null): Collection
    {
        $nodes = $xpath->query($expression, $context);
        $this->assertNotFalse($nodes, "Invalid XPath expression [{$expression}].");

        return collect($nodes)->ensure(DOMElement::class);
    }

    protected function firstElement(DOMXPath $xpath, string $expression): DOMElement
    {
        return $this->elements($xpath, $expression)->firstOrFail();
    }
}
