<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Tests\App\Enums\RoleNames;
use Orchid\Tests\App\Role as RoleWithEnum;
use Orchid\Tests\Unit\Screen\TestFieldsUnitCase;

/**
 * Class SelectTest.
 */
class SelectWithEnumTest extends TestFieldsUnitCase
{
    use WithFaker;
    /**
     * @var Collection
     */
    protected $roles;

    protected function setUp(): void
    {
        parent::setUp();

        collect(RoleNames::cases())
            ->each(function (RoleNames $roleName): void {
                $attributes = Role::factory()->make([
                    'name' => $roleName->value,
                ])->toArray();

                Role::query()->updateOrCreate(
                    ['name' => $roleName->value],
                    $attributes
                );
            });

        $this->roles = RoleWithEnum::query()
            ->whereIn('name', collect(RoleNames::cases())->map->value->all())
            ->get();
    }

    public function testEmptyFromModel(): void
    {
        $select = Select::make('choice')
            ->empty('empty')
            ->fromModel(RoleWithEnum::class, 'name');

        $view = self::minifyRenderField($select);

        foreach ($this->roles as $role) {
            $option = $this->stringOption($role->name->value, $role->id);
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
}
