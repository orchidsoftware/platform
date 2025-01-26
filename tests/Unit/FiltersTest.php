<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Models\User;
use Orchid\Tests\App\Filters\NameFilter;
use Orchid\Tests\App\Filters\PatternFilter;
use Orchid\Tests\App\Filters\WithoutDisplayFilter;
use Orchid\Tests\TestUnitCase;

class FiltersTest extends TestUnitCase
{
    public function test_simple_value(): void
    {
        request()->merge([
            'name' => 'Alexandr',
        ]);

        $value = (new NameFilter)->value();

        $this->assertEquals('Name: Alexandr', $value);
    }

    public function test_multiple_value(): void
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

    public function test_without_display_name(): void
    {
        $name = (new WithoutDisplayFilter)->name();

        $this->assertEquals('WithoutDisplayFilter', $name);
    }

    public function test_pattern_value(): void
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

    public function test_pattern_without_child_value(): void
    {
        request()->merge([
            'pattern' => 'any',
        ]);

        $sql = User::filters([
            new PatternFilter(['pattern.*']),
        ])->toSql();

        $this->assertStringNotContainsString('"pattern" = ?', $sql);
    }

    public function test_pattern_with_nested_value(): void
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
