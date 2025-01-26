<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Fields;

use Illuminate\Foundation\Testing\WithFaker;
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
     * @var \Illuminate\Support\Collection
     */
    protected $roles;

    protected function setUp(): void
    {
        parent::setUp();

        Role::factory()->times(10)->create([
            'name' => $this->faker->randomElement(RoleNames::cases())->value,
        ]);
        $this->roles = RoleWithEnum::all();
    }

    public function test_empty_from_model(): void
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
