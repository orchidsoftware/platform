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
    public function test_macro_field($name = 'customMarcoName'): void
    {
        Field::macro('returnNameMacroFunction', fn () => /** @var Field $this */
$this->get('name'));

        $field = Field::make($name);

        $this->assertEquals($field->returnNameMacroFunction(), $name);
    }

    public function test_macro_field_self_return(): void
    {
        Field::macro('retrunSelf', fn () => /** @var Field $this */
$this);

        $field = Field::make();

        $this->assertEquals($field->retrunSelf(), $field);
    }
}
