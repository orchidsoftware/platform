<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Contracts\View\View;
use Orchid\Tests\TestUnitCase;

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
            [\Orchid\Screen\Fields\Types\TextAreaField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\InputField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\SelectField::class,
                [
                    'name'    => 'example',
                    'options' => [],
                ],],
            [\Orchid\Screen\Fields\Types\RelationshipField::class,
                [
                    'name'    => 'example',
                    'handler' => 'handler',
                ],],
            [\Orchid\Screen\Fields\Types\PlaceField::class,
                [
                    'name' => 'example',
                    'lang' => 'en',
                ],],
            [\Orchid\Screen\Fields\Types\PictureField::class,
                [
                    'name'   => 'example',
                    'width'  => '100',
                    'height' => '100',
                ],],
            [\Orchid\Screen\Fields\Types\DateTimerField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\CheckBoxField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\TinyMCEField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\PasswordField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\SimpleMDEField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\UploadField::class,
                [
                    'name' => 'example',
                ],],
            [\Orchid\Screen\Fields\Types\UTMField::class,
                [
                    'name' => 'example',
                ],],
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
        /** @var \Orchid\Screen\Fields\Field $field */
        $field = new $field();

        foreach ($options as $key => $option) {
            $field->set($key, $option);
        }

        $test = $field->render();

        $this->assertInstanceOf(View::class, $test);
        $this->assertContains('example', $test->withErrors([])->render());
    }
}
