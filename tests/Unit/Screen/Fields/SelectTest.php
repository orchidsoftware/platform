<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Color;
use Orchid\Tests\App\EmptyUserModel;
use Orchid\Tests\App\Enums\RoleNames;
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

    protected function setUp(): void
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

    public function testSetIndicesValue(): void
    {
        $select = Select::make('Indices')
            ->value('1')
            ->options([
                '0' => 'First Value',
                '1' => 'Second Value',
                '2' => 'Third Value',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="1" selected', $view);
    }

    public function testAutoFocus(): void
    {
        $select = Select::make('about')
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

    public function testSelectForNumericArray(): void
    {
        $options = [
            1 => 'First Value',
            2 => 'Second Value',
            3 => 'Third Value',
        ];

        $select = Select::make('choice')
            ->value(1)
            ->options($options);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="1" selected', $view);
    }

    public function testSelectForNumericArrayWhenStringValue(): void
    {
        $options = [
            1 => 'First Value',
            2 => 'Second Value',
            3 => 'Third Value',
        ];

        $select = Select::make('choice')
            ->value('2')
            ->options($options);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="2" selected', $view);
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
     * @param string $value
     */
    private function stringOption($name, $value = ''): string
    {
        $option = '<option value="%s">%s</option>';

        return sprintf($option, $value, $name);
    }

    public function testStrictTypeCasting(): void
    {
        $select = Select::make('choice')
            ->value('-')
            ->options([
                '-' => '-',
                '0' => '0',
                '1' => '1',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('<option value="-" selected>-</option>', $view);
        $this->assertStringContainsString('<option value="0">0</option>', $view);
    }

    public function testMultiple(): void
    {
        $select = Select::make('choice')
            ->multiple()
            ->value([
                'first'  => 'First Value',
                'second' => 'Second Value',
            ])
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
                'third'  => 'Third Value',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('choice[]', $view);
        $this->assertStringContainsString('multiple', $view);

        $this->assertStringContainsString('value="first" selected', $view);
        $this->assertStringContainsString('value="second" selected', $view);
        $this->assertStringNotContainsString('value="third" selected', $view);
    }

    public function testFromEnumWithDisplayName(): void
    {
        $select = Select::make('choice')
            ->value(RoleNames::User)
            ->fromEnum(RoleNames::class, 'label');

        $view = self::minifyRenderField($select);

        // <option value="user" selected>Regular user</option>
        $this->assertStringContainsString('value="'.RoleNames::User->value.'" selected>'.RoleNames::User->label(), $view);
    }

    public function testMultipleFromEnum(): void
    {
        $select = Select::make('choice')
            ->multiple()
            ->value([
                Color::INFO,
                Color::BASIC,
            ])
            ->fromEnum(Color::class);

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('choice[]', $view);
        $this->assertStringContainsString('multiple', $view);

        $this->assertStringContainsString('value="'.Color::BASIC->name.'" selected', $view);
        $this->assertStringContainsString('value="'.Color::INFO->name.'" selected', $view);
        $this->assertStringContainsString('value="'.Color::DARK->name.'"', $view);
        $this->assertStringNotContainsString('value="'.Color::DANGER->name.'" selected', $view);
    }
}
