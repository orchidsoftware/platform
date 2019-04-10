<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\Layouts;
use Orchid\Tests\TestUnitCase;

class LayoutsMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroTD($name = 'customMarcoName')
    {
        Layouts::macro('returnNameMacroFunction', function (string $test) {
            return $test;
        });

        $this->assertEquals(Layouts::returnNameMacroFunction($name), $name);
    }
}
