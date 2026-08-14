<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use App\Orchid\Filters\RoleFilter;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Tests\App\Filters\NameFilter;
use Orchid\Tests\App\Filters\PatternFilter;
use Orchid\Tests\App\Filters\WithoutDisplayFilter;
use Orchid\Tests\TestUnitCase;

class FiltersTest extends TestUnitCase
{
    public function testRoleFilterFiltersAndDisplaysSelectedRole(): void
    {
        $other = Role::factory()->create(['name' => 'Other role']);
        $selected = Role::factory()->create(['name' => 'Selected role']);
        $otherUser = User::factory()->create();
        $selectedUser = User::factory()->create();

        $otherUser->addRole($other);
        $selectedUser->addRole($selected);

        request()->merge([
            'role' => $selected->getKey(),
        ]);

        $filter = new RoleFilter;

        $this->assertSame([$selectedUser->getKey()], $filter->run(User::query())->pluck('id')->all());
        $this->assertSame('Roles: Selected role', $filter->value());
    }

    public function testSimpleValue(): void
    {
        request()->merge([
            'name' => 'Alexandr',
        ]);

        $value = (new NameFilter)->value();

        $this->assertEquals('Name: Alexandr', $value);
    }

    public function testMultipleValue(): void
    {
        request()->merge([
            'name' => [
                'Alexandr',
                'Alena',
            ],
        ]);

        $value = (new NameFilter)->value();

        $this->assertEquals('Name: Alexandr,Alena', $value);
    }

    public function testWithoutDisplayName(): void
    {
        $name = (new WithoutDisplayFilter)->name();

        $this->assertEquals('WithoutDisplayFilter', $name);
    }

    public function testPatternValue(): void
    {
        request()->merge([
            'pattern' => [
                'city' => 'Yelets',
                'name' => 'Alexandr',
            ],
        ]);

        $sql = User::filters([
            new PatternFilter(['pattern.*']),
        ])->toSql();

        $this->assertStringContainsString('"pattern" = ?', $sql);
    }

    public function testPatternWithoutChildValue(): void
    {
        request()->merge([
            'pattern' => 'any',
        ]);

        $sql = User::filters([
            new PatternFilter(['pattern.*']),
        ])->toSql();

        $this->assertStringNotContainsString('"pattern" = ?', $sql);
    }

    public function testPatternWithNestedValue(): void
    {
        request()->merge([
            'test.pattern.name' => 'any',
        ]);

        $sql = User::filters([
            new PatternFilter(['*.pattern.*']),
        ])->toSql();

        $this->assertStringContainsString('"pattern" = ?', $sql);
    }
}
