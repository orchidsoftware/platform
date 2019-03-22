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
            [\Orchid\Screen\Fields\TextArea::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\Input::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\Select::class,
                [
                    'name'    => 'example',
                    'options' => [],
                ], ],
            [\Orchid\Screen\Fields\RadioButtons::class,
             [
                 'name'    => 'example',
                 'options' => ['value' => 'example'],
             ], ],
            [\Orchid\Screen\Fields\Relationship::class,
                [
                    'name'    => 'example',
                    'handler' => 'handler',
                ], ],
            [\Orchid\Screen\Fields\Map::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\Picture::class,
                [
                    'name'   => 'example',
                    'width'  => '100',
                    'height' => '100',
                ], ],
            [\Orchid\Screen\Fields\DateTimer::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\CheckBox::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\TinyMCE::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\Password::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\SimpleMDE::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\Upload::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\UTM::class,
                [
                    'name' => 'example',
                ], ],
            [\Orchid\Screen\Fields\DateRange::class,
             [
                 'name' => 'example',
             ], ],
            [\Orchid\Screen\Fields\Switcher::class,
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
     *
     * @throws \Throwable
     */
    public function testHasCorrectInstance(string $field, $options)
    {
        /** @var \Orchid\Screen\Field $field */
        $field = new $field();

        foreach ($options as $key => $option) {
            $field->set($key, $option);
        }

        $view = $field->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertStringContainsString('example', $view->withErrors([])->render());
    }
}
