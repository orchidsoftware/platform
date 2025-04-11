<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Contracts\View\View;
use Illuminate\Session\Store;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\UTM;
use Orchid\Tests\TestUnitCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Class FieldTest.
 */
class FieldTest extends TestUnitCase
{
    /**
     * @return \Generator
     */
    public static function exampleFields(): ?\Generator
    {
        yield [Input::class, [
            'name' => 'example',
        ]];

        yield [TextArea::class, [
            'name' => 'example',
        ]];

        yield [Select::class, [
            'name'    => 'example',
            'options' => [],
        ]];

        yield [RadioButtons::class, [
            'name'    => 'example',
            'options' => ['value' => 'example'],
        ]];

        yield [Map::class, [
            'name' => 'example',
        ]];

        yield [Cropper::class, [
            'name'   => 'example',
            'width'  => '100',
            'height' => '100',
        ]];

        yield [DateTimer::class, [
            'name' => 'example',
        ]];

        yield [CheckBox::class, [
            'name' => 'example',
        ]];

        yield [SimpleMDE::class, [
            'name' => 'example',
        ]];

        yield [Upload::class, [
            'name' => 'example',
        ]];

        yield [Password::class, [
            'name' => 'example',
        ]];

        yield [UTM::class, [
            'name' => 'example',
        ]];

        yield [DateRange::class, [
            'name' => 'example',
        ]];

        yield [Switcher::class, [
            'name' => 'example',
        ]];

        yield [Picture::class, [
            'name' => 'example',
        ]];

        yield [Code::class, [
            'name' => 'example',
        ]];

        yield [Cropper::class, [
            'name' => 'example',
        ]];

        yield [DateTimer::class, [
            'name' => 'example',
        ]];
    }

    /**
     * @dataProvider exampleFields
     *
     * @throws \Throwable
     */
    #[DataProvider('exampleFields')]
    public function testHasCorrectInstance(string $field, mixed $options): void
    {
        /** @var \Orchid\Screen\Field $field */
        $field = $field::make();

        foreach ($options as $key => $option) {
            $field->set($key, $option);
        }

        $view = $field->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertStringContainsString('example', $view->withErrors([])->render());
    }

    public function testUniqueId(): void
    {
        $collect = collect(range(0, 10000));

        $fields = $collect->map(fn ($value) => (new Field)->set('value', $value)->getId())->unique();

        $this->assertEquals($fields->count(), $collect->count());

        $expected = (new Field)->set('value', 'test')->getId();
        $actual = (new Field)->set('value', 'test')->getId();

        $this->assertEquals($expected, $actual);
    }

    public function testOldNameMatchesLaravelRequestOldPrefix()
    {
        $field = new Field;

        $field->set('name', 'parent[child][grandchild]');

        $this->assertEquals('parent.child.grandchild', $field->getOldName());

        $field = new Field;

        $field->set('name', 'parent[child][grandchild][]');

        $this->assertEquals('parent.child.grandchild', $field->getOldName());
    }

    public function testOldNameMatchesLaravelRequestOldPrefixWithErrors()
    {
        $field = new Input;
        $field->set('name', 'parent[child][grandchild]');

        $view = $field->render();

        $html = $view->withErrors([
            'parent.child.grandchild' => 'testError',
        ])->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertStringContainsString('testError', $html);
        $this->assertStringContainsString('parent[child][grandchild]', $html);

        $field = new Input;
        $field->set('name', 'parent[child][grandchild][]');

        $view = $field->render();

        $html = $view->withErrors([
            'parent.child.grandchild' => 'testError',
        ])->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertStringContainsString('testError', $html);
        $this->assertStringContainsString('parent[child][grandchild][]', $html);
    }

    public function testOldName(): void
    {
        $session = tap(app()->make(Store::class), function ($session) {
            $session->start();
            $session->put('_old_input', [
                'name' => "The heart of Seoul's nightlife",
            ]);
        });

        request()->setLaravelSession($session);

        $this->assertSame("The heart of Seoul's nightlife", Input::make('name')->getOldValue());
    }

    public function testNumericOldName(): void
    {
        $session = tap(app()->make(Store::class), function ($session) {
            $session->start();
            $session->put('_old_input', [
                'numeric' => '3.141',
            ]);
        });

        request()->setLaravelSession($session);

        $this->assertSame('3.141', Input::make('numeric')->getOldValue());
    }

    public function testAddsSingleClassToEmptyClassAttribute(): void
    {
        $field = Field::make('test');
        $field->addClass('new-class');

        $this->assertEquals('new-class', $field->get('class'));
    }

    public function testAddsMultipleClassesToEmptyClassAttribute(): void
    {
        $field = Field::make('test');
        $field->addClass('class1 class2');

        $this->assertEquals('class1 class2', $field->get('class'));
    }

    public function testAddsArrayOfClassesToEmptyClassAttribute(): void
    {
        $field = Field::make('test');
        $field->addClass(['class1', 'class2']);

        $this->assertEquals('class1 class2', $field->get('class'));
    }

    public function testAddsNewClassToExistingClasses(): void
    {
        $field = Field::make('test')->set('class', 'existing-class');
        $field->addClass('new-class');

        $this->assertEquals('existing-class new-class', $field->get('class'));
    }

    public function testDoesNotDuplicateClasses(): void
    {
        $field = Field::make('test')->set('class', 'existing-class');
        $field->addClass('existing-class new-class');

        $this->assertEquals('existing-class new-class', $field->get('class'));
    }
}
