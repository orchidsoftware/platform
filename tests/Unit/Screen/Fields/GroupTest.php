<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class GroupTest extends TestFieldsUnitCase
{
    public function testItCanBeInstantiatedWithMake()
    {
        $group = Group::make();

        $this->assertInstanceOf(Group::class, $group);
        $this->assertSame([], $group->getGroup());
    }

    public function testItCanSetAndGetGroupFields()
    {
        $inputA = Input::make('name');
        $inputB = Input::make('email');

        $group = Group::make([$inputA, $inputB]);

        $this->assertCount(2, $group->getGroup());
        $this->assertSame([$inputA, $inputB], $group->getGroup());
    }

    public function testItCanSetCustomAttributes()
    {
        $group = Group::make()->set('align', 'align-items-center');

        $this->assertSame('align-items-center', $group->get('align'));
    }

    public function testItCanUseAutoWidth()
    {
        $group = Group::make([
            Input::make('a'),
            Input::make('b'),
            Input::make('c'),
        ])->autoWidth();

        $this->assertSame('repeat(3, max-content)', $group->get('widthColumns'));
    }

    public function testItCanUseFullWidth()
    {
        $group = Group::make([
            Input::make('x'),
            Input::make('y'),
        ])->fullWidth();

        $this->assertNull($group->get('widthColumns'));
    }

    public function testItCanSetCustomWidthTemplate()
    {
        $group = Group::make()->widthColumns('1fr 2fr 1fr');

        $this->assertSame('1fr 2fr 1fr', $group->get('widthColumns'));
    }

    public function testItCanChangeAlignment()
    {
        $group = Group::make();

        $this->assertSame('align-items-baseline', $group->get('align'));

        $group->alignCenter();
        $this->assertSame('align-items-center', $group->get('align'));

        $group->alignEnd();
        $this->assertSame('align-items-end', $group->get('align'));

        $group->alignStart();
        $this->assertSame('align-items-start', $group->get('align'));

        $group->alignBaseLine();
        $this->assertSame('align-items-baseline', $group->get('align'));
    }

    public function testItCanSetItemToEnd()
    {
        $group = Group::make()->toEnd();

        $this->assertTrue($group->get('itemToEnd'));
    }

    public function testItRendersViewWhenGroupIsNotEmpty()
    {
        $group = Group::make([
            Input::make('visible'),
        ]);

        $view = $group->render();

        $this->assertInstanceOf(\Illuminate\View\View::class, $view);
        $this->assertSame('platform::fields.group', $view->getName());
        $this->assertArrayHasKey('group', $view->getData());
    }

    public function testItDoesNotRenderViewWhenGroupIsEmpty()
    {
        $group = Group::make([]);

        $this->assertNull($group->render());
    }

    public function testItConvertsToStringCorrectly()
    {
        $group = Group::make([Input::make('x')]);

        $this->assertIsString((string) $group);
        $this->assertStringContainsString('input', (string) $group);
    }

    public function testItAppliesFormNameToAllFields()
    {
        $group = Group::make([
            Input::make('a'),
            Input::make('b'),
        ])->form('customForm');

        foreach ($group->getGroup() as $field) {
            $this->assertSame('customForm', $field->get('form'));
        }
    }

    public function testItReturnsAllAttributes()
    {
        $group = Group::make([
            Input::make('test'),
        ])->alignCenter()->widthColumns('1fr 2fr')->toEnd();

        $attributes = $group->getAttributes();

        $this->assertIsArray($attributes);
        $this->assertArrayHasKey('group', $attributes);
        $this->assertArrayHasKey('align', $attributes);
        $this->assertArrayHasKey('widthColumns', $attributes);
        $this->assertArrayHasKey('itemToEnd', $attributes);
    }
}
