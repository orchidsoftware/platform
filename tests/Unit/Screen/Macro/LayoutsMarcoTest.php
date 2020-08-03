<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\Layout;
use Orchid\Tests\TestUnitCase;

class LayoutsMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroTD($name = 'customMarcoName'): void
    {
        Layout::macro('returnNameMacroFunction', function (string $test) {
            return $test;
        });

        $this->assertEquals(Layout::returnNameMacroFunction($name), $name);
    }
}
