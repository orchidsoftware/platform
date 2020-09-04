<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\LayoutFactory;
use Orchid\Tests\TestUnitCase;

class LayoutsMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroTD($name = 'customMarcoName'): void
    {
        LayoutFactory::macro('returnNameMacroFunction', function (string $test) {
            return $test;
        });

        $this->assertEquals(LayoutFactory::returnNameMacroFunction($name), $name);
    }
}
