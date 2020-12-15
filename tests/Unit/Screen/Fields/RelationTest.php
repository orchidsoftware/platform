<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Relation;
use Orchid\Tests\App\EmptyUserModel;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class RelationTest.
 */
class RelationTest extends TestFieldsUnitCase
{
    /**
     * @var Collection
     */
    protected $roles;

    /**
     * @var Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->roles = Role::factory()->times(10)->create();
        $this->users = User::factory()->times(10)->create();
    }

    public function testInstance(): void
    {
        /** @var Role $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select role')
            ->fromModel(Role::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name, $view);
        $this->assertStringContainsString('Select role', $view);
    }

    public function testInstanceArray(): void
    {
        /** @var Role $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select roles')
            ->fromModel(Role::class, 'name')
            ->value($current->id);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name, $view);
        $this->assertStringContainsString('Select roles', $view);
    }

    public function testInstanceArrayWithStringPrimary(): void
    {
        $stringPrimaryClass = new class extends Role {
            protected $primaryKey = 'slug';
        };

        /** @var Role $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select roles')
            ->fromModel(get_class(new $stringPrimaryClass), 'name')
            ->value($current->getRoleSlug());

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name, $view);
        $this->assertStringContainsString('Select roles', $view);
    }

    public function testMultipleInstance(): void
    {
        /** @var Role $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(Role::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name, $view);
        $this->assertStringContainsString($current[1]->name, $view);
    }

    public function testMultipleInstanceArray(): void
    {
        /** @var Role $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(Role::class, 'name')
            ->value([
                $current[0]->id,
                $current[1]->id,
            ]);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name, $view);
        $this->assertStringContainsString($current[1]->name, $view);
    }

    public function testNotScope(): void
    {
        $select = Relation::make('users')
            ->fromModel(EmptyUserModel::class, 'name');

        $view = self::renderField($select);

        $this->assertStringContainsString('data-fields--relation-scope=""', $view);
    }

    public function testScopeWithAttributes(): void
    {
        $select = Relation::make('users')
            ->fromModel(EmptyUserModel::class, 'name')
            ->applyScope('exampleScope', 1, 'string', ['foo', 'bar']);

        $view = self::renderField($select);

        $crypt = Str::between($view, 'data-fields--relation-scope="', '=="');

        $this->assertEquals([
            'name'       => lcfirst('exampleScope'),
            'parameters' => [1, 'string', ['foo', 'bar']],
        ], Crypt::decrypt($crypt));
    }

    public function testScopeWithNotAttributes(): void
    {
        $select = Relation::make('users')
            ->fromClass(EmptyUserModel::class, 'name')
            ->applyScope('exampleScope');

        $view = self::renderField($select);

        $crypt = Str::between($view, 'data-fields--relation-scope="', '=="');

        $this->assertEquals([
            'name'       => lcfirst('exampleScope'),
            'parameters' => [],
        ], Crypt::decrypt($crypt));
    }

    public function testScopeWithInstance(): void
    {
        /** @var User $current */
        $current = $this->users->random();

        // With parameters
        $select = Relation::make('users')
            ->value($current->id)
            ->fromClass(EmptyUserModel::class, 'name')
            ->applyScope('asFilerId', $current->id);

        $this->assertStringContainsString($current->name, self::renderField($select));

        // Invalid parameter
        $select = Relation::make('users')
            ->value($current->id)
            ->fromClass(EmptyUserModel::class, 'name')
            ->applyScope('asFilerId', 0);

        $this->assertStringNotContainsString($current->name, self::renderField($select));
    }

    public function testSearchColumns(): void
    {
        $select = Relation::make('users')
            ->fromModel(EmptyUserModel::class, 'name')
            ->searchColumns('email', 'id');

        $view = self::renderField($select);

        $crypt = Str::between($view, 'data-fields--relation-search-columns="', '=="');

        $this->assertEquals(['email', 'id'], Crypt::decrypt($crypt));
    }
}
