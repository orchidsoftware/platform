<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Tests\App\EmptyUserModel;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class SelectTest.
 */
class SelectTest extends TestFieldsUnitCase
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $roles;

    public function setUp(): void
    {
        parent::setUp();

        $this->roles = Role::factory()->times(10)->create();
    }

    public function testInstance(): void
    {
        $select = Select::make('choice')
            ->title('Title About')
            ->help('Think about what you want to tell')
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ]);

        $view = self::renderField($select);

        $this->assertStringContainsString('First Value', $view);
        $this->assertStringContainsString('Second Value', $view);
        $this->assertStringContainsString('Third Value', $view);

        $this->assertStringContainsString('first', $view);
        $this->assertStringContainsString('second', $view);
        $this->assertStringContainsString('third', $view);

        $this->assertStringContainsString('Title About', $view);
        $this->assertStringContainsString('Think about what you want to tell', $view);
    }

    public function testNeedRequire(): void
    {
        $select = Select::make('choice')
            ->options([])
            ->required();

        $view = self::renderField($select);

        $this->assertStringContainsString('required', $view);
    }

    public function testSetValue(): void
    {
        $select = Select::make('choice')
            ->value('second')
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="second" selected', $view);
    }

    public function testAutoFocus(): void
    {
        $select = TextArea::make('about')
            ->autofocus();

        $view = self::renderField($select);

        $this->assertStringContainsString('autofocus', $view);
    }

    public function testEmptyForAssociativeArray(): void
    {
        $options = [
            'first'  => 'First Value',
            'second' => 'Second Value',
            'third'  => 'Third Value',
        ];

        $select = Select::make('choice')
            ->options($options)
            ->empty('empty', '0');

        $view = self::minifyRenderField($select);

        foreach ($options as $key => $option) {
            $option = $this->stringOption($option, $key);
            $this->assertStringContainsString($option, $view);
        }

        $option = $this->stringOption('empty', '0');
        $this->assertStringContainsString($option, $view);
    }

    public function testEmptyForNumericArray(): void
    {
        $options = [
            1 => 'First Value',
            2 => 'Second Value',
            3 => 'Third Value',
        ];

        $select = Select::make('choice')
            ->options($options)
            ->empty('empty');

        $view = self::minifyRenderField($select);

        foreach ($options as $key => $option) {
            $option = $this->stringOption($option, $key);
            $this->assertStringContainsString($option, $view);
        }

        $option = $this->stringOption('empty');
        $this->assertStringContainsString($option, $view);
    }

    public function testEmptyFromModel(): void
    {
        $select = Select::make('choice')
            ->empty('empty')
            ->fromModel(Role::class, 'name');

        $view = self::minifyRenderField($select);

        foreach ($this->roles as $role) {
            $option = $this->stringOption($role->name, $role->id);
            $this->assertStringContainsString($option, $view);
        }

        $option = $this->stringOption('empty');
        $this->assertStringContainsString($option, $view);
    }

    public function testAttributesCanBeUsed(): void
    {
        $select = Select::make('choice')
            ->empty('empty')
            ->fromQuery(EmptyUserModel::orderBy('id'), 'full');

        $view = self::minifyRenderField($select);

        foreach (EmptyUserModel::all() as $user) {
            $option = $this->stringOption($user->full, $user->id);
            $this->assertStringContainsString($option, $view);
        }

        $option = $this->stringOption('empty');
        $this->assertStringContainsString($option, $view);
    }

    /**
     * @param        $name
     * @param string $value
     *
     * @return string
     */
    private function stringOption($name, $value = ''): string
    {
        $option = '<option value="%s">%s</option>';

        return sprintf($option, $value, $name);
    }
}
