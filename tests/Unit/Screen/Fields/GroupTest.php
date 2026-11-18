<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\View\View;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

class GroupTest extends TestFieldsUnitCase
{
    public function testItCanBeInstantiatedWithMake(): void
    {
        $group = Group::make();

        $this->assertSame([], $group->getGroup());
    }

    public function testItCanSetAndGetGroupFields(): void
    {
        $inputA = Input::make('name');
        $inputB = Input::make('email');

        $group = Group::make([$inputA, $inputB]);

        $this->assertCount(2, $group->getGroup());
        $this->assertSame([$inputA, $inputB], $group->getGroup());
    }

    public function testItCanSetCustomAttributes(): void
    {
        $group = Group::make()->set('align', 'align-items-center');

        $this->assertSame('align-items-center', $group->get('align'));
    }

    public function testItCanUseAutoWidth(): void
    {
        $group = Group::make([
            Input::make('a'),
            Input::make('b'),
            Input::make('c'),
        ])->autoWidth();

        $this->assertSame('repeat(3, max-content)', $group->get('widthColumns'));
    }

    public function testItCanUseFullWidth(): void
    {
        $group = Group::make([
            Input::make('x'),
            Input::make('y'),
        ])->fullWidth();

        $this->assertNull($group->get('widthColumns'));
    }

    public function testItCanSetCustomWidthTemplate(): void
    {
        $group = Group::make()->widthColumns('1fr 2fr 1fr');

        $this->assertSame('1fr 2fr 1fr', $group->get('widthColumns'));
    }

    public function testItCanChangeAlignment(): void
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

    public function testItCanSetItemToEnd(): void
    {
        $group = Group::make()->toEnd();

        $this->assertTrue($group->get('itemToEnd'));
    }

    public function testItRendersViewWhenGroupIsNotEmpty(): void
    {
        $group = Group::make([
            Input::make('visible'),
        ]);

        $view = $group->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('orchid::fields.group', $view->getName());
        $this->assertArrayHasKey('group', $view->getData());
    }

    public function testItDoesNotRenderViewWhenGroupIsEmpty(): void
    {
        $group = Group::make([]);

        $this->assertNull($group->render());
    }

    public function testItConvertsToStringCorrectly(): void
    {
        $group = Group::make([Input::make('x')]);

        $this->assertStringContainsString('input', (string) $group);
    }

    public function testItAppliesFormNameToAllFields(): void
    {
        $group = Group::make([
            Input::make('a'),
            Input::make('b'),
        ])->form('customForm');

        foreach ($group->getGroup() as $field) {
            $this->assertSame('customForm', $field->get('form'));
        }
    }

    public function testItReturnsAllAttributes(): void
    {
        $group = Group::make([
            Input::make('test'),
        ])->alignCenter()->widthColumns('1fr 2fr')->toEnd();

        $attributes = $group->getAttributes();

        $this->assertArrayHasKey('group', $attributes);
        $this->assertArrayHasKey('align', $attributes);
        $this->assertArrayHasKey('widthColumns', $attributes);
        $this->assertArrayHasKey('itemToEnd', $attributes);
    }

    public function testItCanBeNested(): void
    {
        $group = Group::make([
            Group::make([
                Input::make('test'),
            ]),
        ]);

        $this->assertStringContainsString('input', $group->render()->render());
    }
}
