<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\LayoutFactory;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class LayoutsMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroLayout($name = 'customMarcoName'): void
    {
        LayoutFactory::macro('returnNameMacroFunction', function (string $test) {
            return $test;
        });

        $this->assertEquals(LayoutFactory::returnNameMacroFunction($name), $name);
    }

    /**
     * @param string $name
     */
    public function testMacroLayoutFacade($name = 'customMarcoNameFacade'): void
    {
        LayoutFactory::macro('returnNameMacroFunctionFacade', function (string $test) {
            return $test;
        });

        $this->assertEquals(Layout::returnNameMacroFunctionFacade($name), $name);
    }
}
