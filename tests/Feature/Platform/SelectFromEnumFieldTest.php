<?php

namespace Orchid\Tests\Feature\Platform;

use Orchid\Platform\Models\Role;
use Orchid\Tests\App\Enums\RoleNames;
use Orchid\Tests\App\Role as RoleWithEnum;
use Orchid\Tests\TestFeatureCase;

class SelectFromEnumFieldTest extends TestFeatureCase
{
    /**
     * @var RoleWithEnum
     */
    private $role;

    protected function setUp(): void
    {
        parent::setUp();
        Role::factory()->create([
            'name' => RoleNames::Admin->value,
        ]);
        $this->role = RoleWithEnum::find(1);
    }

    public function testBase(): void
    {
        $this
            ->actingAs($this->createAdminUser())
            ->get(route('test.select-from-enum-field-screen'))
            ->assertSuccessful()
            ->assertSee(RoleNames::Admin->name);
    }
}
