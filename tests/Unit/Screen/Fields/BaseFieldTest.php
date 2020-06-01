<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Exceptions\FieldRequiredAttributeException;
use Orchid\Screen\Field;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class BaseFieldTest.
 */
class BaseFieldTest extends TestFieldsUnitCase
{
    /**
     * @var \Orchid\Screen\Field
     */
    public $field;

    public function setUp(): void
    {
        $field = new class extends Field {
            /**
             * @var string
             */
            public $view = '';

            /**
             * Default attributes value.
             *
             * @var array
             */
            public $attributes = [
                'class' => 'form-control',
            ];

            /**
             * @var array
             */
            public $required = [
                'name',
                'height',
            ];
        };

        $this->field = $field;
    }

    public function testRequredAttributeNameField()
    {
        $this->expectException(FieldRequiredAttributeException::class);
        $this->expectExceptionMessage('Field must have the following attribute: name');

        $this->field->render();
    }

    public function testRequredAttributeHeightField()
    {
        $this->expectException(FieldRequiredAttributeException::class);
        $this->expectExceptionMessage('Field must have the following attribute: height');

        $this->field->set('name', 'First name');
        $this->field->render();
    }

    public function testNoDisplay()
    {
        $this->assertNull($this->field->canSee(false)->render());
    }
}
