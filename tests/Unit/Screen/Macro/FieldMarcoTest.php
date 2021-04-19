<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Macro;

use Orchid\Screen\Field;
use Orchid\Tests\TestUnitCase;

class FieldMarcoTest extends TestUnitCase
{
    /**
     * @param string $name
     */
    public function testMacroField($name = 'customMarcoName'): void
    {
        Field::macro('returnNameMacroFunction', function () {
            /** @var Field $this */
            return $this->get('name');
        });

        $field = Field::make($name);

        $this->assertEquals($field->returnNameMacroFunction(), $name);
    }

    public function testMacroFieldSelfReturn(): void
    {
        Field::macro('retrunSelf', function () {
            /** @var Field $this */
            return $this;
        });

        $field = Field::make();

        $this->assertEquals($field->retrunSelf(), $field);
    }
}
