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
        LayoutFactory::macro('returnNameMacroFunction', fn (string $test) => $test);

        $this->assertEquals(LayoutFactory::returnNameMacroFunction($name), $name);
    }

    /**
     * @param string $name
     */
    public function testMacroLayoutFacade($name = 'customMarcoNameFacade'): void
    {
        LayoutFactory::macro('returnNameMacroFunctionFacade', fn (string $test) => $test);

        $this->assertEquals(Layout::returnNameMacroFunctionFacade($name), $name);
    }
}
