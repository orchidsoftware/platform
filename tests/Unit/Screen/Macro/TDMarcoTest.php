<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\TD;
use Orchid\Tests\TestUnitCase;

class TDMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroTD($name = 'customMarcoName'): void
    {
        TD::macro('returnNameMacroFunction', fn() => /* @var TD $this */
$this->name);

        $td = new TD($name);

        $this->assertEquals($td->returnNameMacroFunction(), $name);
    }
}
