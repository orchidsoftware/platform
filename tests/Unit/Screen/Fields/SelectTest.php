<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
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
     * @var Collection
     */
    protected $roles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->roles = Role::factory()->times(10)->create();
    }

    /*
     * Basic rendering and attributes.
     */

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

    public function testAutoFocus(): void
    {
        $select = Select::make('about')
            ->autofocus();

        $view = self::renderField($select);

        $this->assertStringContainsString('autofocus', $view);
    }

    public function testAllowCreate(): void
    {
        $select = Select::make('choice')
            ->allowCreate()
            ->options([]);

        $view = self::renderField($select);

        $this->assertStringContainsString('data-select-allow-create-value="true"', $view);
    }

    public function testAllowEmptyUsesBooleanStimulusValue(): void
    {
        $select = Select::make('choice')
            ->options([]);

        $view = self::renderField($select);

        $this->assertStringContainsString('data-select-allow-empty-value="false"', $view);

        $select = Select::make('choice')
            ->allowEmpty()
            ->options([]);

        $view = self::renderField($select);

        $this->assertStringContainsString('data-select-allow-empty-value="true"', $view);
    }

    public function testDeprecatedAllowAddAlias(): void
    {
        $select = Select::make('choice')
            ->allowAdd()
            ->options([]);

        $view = self::renderField($select);

        $this->assertStringContainsString('data-select-allow-create-value="true"', $view);
    }

    /*
     * Selection from plain arrays.
     */

    public function testSelectsScalarValueFromArrayOptions(): void
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

    public function testSelectsNumericValueFromArrayOptions(): void
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

    public function testSelectsStringValueFromNumericArrayOptions(): void
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

    public function testSelectsMultipleValuesFromAssociativeValueMap(): void
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

    /*
     * Empty option handling.
     */

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
        $this->assertStringContainsString('data-select-allow-empty-value="true"', $view);
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

    /*
     * Eloquent model and query builder sources.
     */

    public function testFromModelRendersModelOptions(): void
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

    public function testFromModelCanSelectModelValue(): void
    {
        /** @var Role $role */
        $role = $this->roles->random();

        $select = Select::make('choice')
            ->value($role)
            ->fromModel(Role::class, 'name');

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="'.$role->id.'" selected', $view);
    }

    public function testFromModelCanSelectMultipleModelValues(): void
    {
        $roles = $this->roles->random(2);

        $select = Select::make('choice')
            ->multiple()
            ->value($roles)
            ->fromModel(Role::class, 'name');

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="'.$roles[0]->id.'" selected', $view);
        $this->assertStringContainsString('value="'.$roles[1]->id.'" selected', $view);
    }

    public function testFromModelCanSelectStringPrimaryKey(): void
    {
        $stringPrimaryClass = new class extends Role
        {
            protected $primaryKey = 'name';
        };

        /** @var Role $role */
        $role = $stringPrimaryClass::query()->firstOrFail();

        $select = Select::make('choice')
            ->value($role->getKey())
            ->fromModel($stringPrimaryClass::class, 'id');

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('value="'.$role->name.'" selected', $view);
    }

    public function testFromQueryRendersBuilderResults(): void
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

    /*
     * Lazy choices loading.
     */

    public function testLazyFromModelRendersChoicesContract(): void
    {
        $select = Select::make('choice')
            ->fromModel(Role::class, 'name')
            ->applyScope('exampleScope', 1)
            ->searchColumns('slug')
            ->displayAppend('name')
            ->lazy(25);

        $view = self::renderField($select);
        $payload = Crypt::decrypt(Str::betweenFirst($view, 'data-select-choices-value="', '"'));

        $this->assertStringContainsString('data-select-route-value="'.route('orchid.choices').'"', $view);
        $this->assertStringContainsString('data-select-chunk-value="25"', $view);
        $this->assertStringContainsString('data-select-target="select"', $view);
        $this->assertStringNotContainsString('data-select-model-value', $view);
        $this->assertStringNotContainsString('data-select-name-value', $view);

        $this->assertEquals([
            'model'         => Role::class,
            'name'          => 'name',
            'key'           => 'id',
            'chunk'         => 25,
            'scope'         => [
                'name'       => 'exampleScope',
                'parameters' => [1],
            ],
            'append'        => 'name',
            'searchColumns' => ['slug'],
        ], $payload);
    }

    public function testLazyFromModelCanSelectScalarValue(): void
    {
        /** @var Role $role */
        $role = $this->roles->random();

        $select = Select::make('choice')
            ->value($role->id)
            ->fromModel(Role::class, 'name')
            ->lazy();

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('<option selected value="'.$role->id.'">'.$role->name.'</option>', $view);
    }

    public function testLazyFromModelCanSelectMultipleScalarValues(): void
    {
        $roles = $this->roles->random(2);

        $select = Select::make('choice')
            ->multiple()
            ->value([
                $roles[0]->id,
                $roles[1]->id,
            ])
            ->fromModel(Role::class, 'name')
            ->lazy();

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('<option selected value="'.$roles[0]->id.'">'.$roles[0]->name.'</option>', $view);
        $this->assertStringContainsString('<option selected value="'.$roles[1]->id.'">'.$roles[1]->name.'</option>', $view);
    }

    public function testLazyFromModelCanBeCalledBeforeFromModel(): void
    {
        /** @var Role $role */
        $role = $this->roles->random();

        $select = Select::make('choice')
            ->value($role)
            ->lazy(5)
            ->fromModel(Role::class, 'name');

        $view = self::minifyRenderField($select);

        $this->assertStringContainsString('data-select-chunk-value="5"', $view);
        $this->assertStringContainsString('<option selected value="'.$role->id.'">'.$role->name.'</option>', $view);
    }

    public function testLazyIsIgnoredWithoutModelChoices(): void
    {
        $select = Select::make('choice')
            ->value('second')
            ->lazy()
            ->options([
                'first'  => 'First Value',
                'second' => 'Second Value',
            ]);

        $view = self::minifyRenderField($select);

        $this->assertStringNotContainsString('data-select-route-value', $view);
        $this->assertStringNotContainsString('data-select-choices-value', $view);
        $this->assertStringContainsString('value="second" selected', $view);
    }

    /*
     * Enum sources and values.
     */

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

    /**
     * @param string $value
     */
    private function stringOption($name, $value = ''): string
    {
        $option = '<option value="%s">%s</option>';

        return sprintf($option, $value, $name);
    }
}
