<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\Relation;
use Orchid\Tests\App\Enums\RoleNames;
use Orchid\Tests\App\Role as RoleWithEnum;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class RelationTest.
 */
class RelationWithEnumTest extends TestFieldsUnitCase
{
    use WithFaker;
    /**
     * @var Collection
     */
    protected $roles;

    /**
     * @var Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $users;

    protected function setUp(): void
    {
        parent::setUp();

        Role::factory()->times(10)->create([
            'name' => $this->faker->randomElement(RoleNames::cases())->value,
        ]);
        $this->roles = RoleWithEnum::all();
        $this->users = User::factory()->times(10)->create();
    }

    public function test_instance(): void
    {
        /** @var RoleWithEnum $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select role')
            ->fromModel(RoleWithEnum::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name->value, $view);
        $this->assertStringContainsString('Select role', $view);
    }

    public function test_instance_array(): void
    {
        /** @var RoleWithEnum $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select roles')
            ->fromModel(RoleWithEnum::class, 'name')
            ->value($current->id);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name->value, $view);
        $this->assertStringContainsString('Select roles', $view);
    }

    public function test_instance_array_with_string_primary(): void
    {
        $stringPrimaryClass = new class extends RoleWithEnum
        {
            protected $primaryKey = 'slug';
        };

        /** @var RoleWithEnum $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select roles')
            ->fromModel(get_class(new $stringPrimaryClass), 'name')
            ->value($current->getRoleSlug());

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name->value, $view);
        $this->assertStringContainsString('Select roles', $view);
    }

    public function test_multiple_instance(): void
    {
        /** @var RoleWithEnum $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(RoleWithEnum::class, 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name->value, $view);
        $this->assertStringContainsString($current[1]->name->value, $view);
    }

    public function test_multiple_instance_array(): void
    {
        /** @var RoleWithEnum $current */
        $current = $this->roles->random(2);

        $select = Relation::make('role.')
            ->fromModel(RoleWithEnum::class, 'name')
            ->value([
                $current[0]->id,
                $current[1]->id,
            ]);

        $view = self::renderField($select);

        $this->assertStringContainsString($current[0]->name->value, $view);
        $this->assertStringContainsString($current[1]->name->value, $view);
    }

    public function test_instance_with_enum_key(): void
    {
        /** @var RoleWithEnum $current */
        $current = $this->roles->random();

        $select = Relation::make('role')
            ->title('Select role')
            ->fromModel(RoleWithEnum::class, 'name', 'name')
            ->value($current);

        $view = self::renderField($select);

        $this->assertStringContainsString($current->name->value, $view);
        $this->assertStringContainsString('Select role', $view);
    }
}
