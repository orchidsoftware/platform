<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\TestUnitCase;
use Illuminate\Contracts\View\View;

/**
 * Class FieldTest.
 */
class FieldTest extends TestUnitCase
{
    /**
     * @return array
     */
    public function exampleFields()
    {
        return [
            [\Orchid\Screen\Fields\TextAreaField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\InputField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\SelectField::class,
                [
                    'name'    => 'example',
                    'options' => [],
                ], ],
            [\Orchid\Screen\Fields\RadioButtonsField::class,
             [
                 'name'    => 'example',
                 'options' => [],
             ], ],
            [\Orchid\Screen\Fields\RelationshipField::class,
                [
                    'name'    => 'example',
                    'handler' => 'handler',
                ], ],
            [\Orchid\Screen\Fields\MapField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\PictureField::class,
                [
                    'name'   => 'example',
                    'width'  => '100',
                    'height' => '100',
                ], ],
            [\Orchid\Screen\Fields\DateTimerField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\CheckBoxField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\TinyMCEField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\PasswordField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\SimpleMDEField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\UploadField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\UTMField::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\DateRangeField::class,
             [
                 'name' => 'example',
             ], ],
            [\Orchid\Screen\Fields\SwitchField::class,
             [
                 'name' => 'example',
             ], ],
        ];
    }

    /**
     * @param string $field
     * @param mixed  $options
     *
     * @dataProvider exampleFields
     * @throws \Throwable
     */
    public function testFields(string $field, $options)
    {
        /** @var \Orchid\Screen\Field $field */
        $field = new $field();

        foreach ($options as $key => $option) {
            $field->set($key, $option);
        }

        $test = $field->render();

        $this->assertInstanceOf(View::class, $test);
        $this->assertContains('example', $test->withErrors([])->render());
    }
}
