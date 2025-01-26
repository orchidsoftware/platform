<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Models\User;
use Orchid\Tests\App\Filters\EmailFilter;
use Orchid\Tests\App\Filters\NameFilter;
use Orchid\Tests\App\Layouts\GroupNameAndEmail;
use Orchid\Tests\TestUnitCase;

class ModelFiltersTest extends TestUnitCase
{
    public function test_not_params_filters_apply(): void
    {
        $sql = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $this->assertEquals('select * from "users"', $sql);
    }

    public function test_only_one_params_filters_apply(): void
    {
        request()->merge([
            'name' => 'Alexandr',
        ]);

        $sql = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $this->assertEquals('select * from "users" where "name" = ?', $sql);
    }

    public function test_many_params_filters_apply(): void
    {
        request()->merge([
            'name'  => 'Alexandr',
            'email' => 'bliz48rus@gmail.com',
        ]);

        $sql = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $this->assertEquals('select * from "users" where "name" = ? and "email" = ?', $sql);
    }

    public function test_many_params_filters_apply_with_http_and_default_sort(): void
    {
        request()->merge([
            'name'  => 'Alexandr',
            'email' => 'bliz48rus@gmail.com',
        ]);

        $sql = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])
            ->filters()
            ->defaultSort('created_at', 'asc')
            ->toSql();

        $this->assertEquals('select * from "users" where "name" = ? and "email" = ? order by "created_at" asc', $sql);
    }

    public function test_default_sort(): void
    {
        $sql = User::filters()->defaultSort('created_at')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" asc', $sql);

        $sql = User::filters()->defaultSort('created_at', 'desc')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" desc', $sql);
    }

    public function test_default_sort_with_params(): void
    {
        request()->merge([
            'sort' => '-created_at',
        ]);

        $sql = User::filters()->defaultSort('created_at')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" desc', $sql);

        request()->merge([
            'sort' => 'created_at',
        ]);

        $sql = User::filters()->defaultSort('created_at', 'desc')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" asc', $sql);
    }

    public function test_filters_apply_some_selection(): void
    {
        request()->merge([
            'name'  => 'Alexandr',
            'email' => 'bliz48rus@gmail.com',
        ]);

        $sqlApply = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $sqlSelection = User::filtersApplySelection(GroupNameAndEmail::class)->toSql();

        $this->assertSame($sqlApply, $sqlSelection);
    }

    public function test_short_filters(): void
    {
        request()->merge([
            'name'  => 'Alexandr',
            'email' => 'bliz48rus@gmail.com',
        ]);

        $sqlApply = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $shortSqlApply = User::filters([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $this->assertSame($sqlApply, $shortSqlApply);

        $sqlSelection = User::filtersApplySelection(GroupNameAndEmail::class)->toSql();
        $shortSqlSelection = User::filters(GroupNameAndEmail::class)->toSql();

        $this->assertSame($sqlSelection, $shortSqlSelection);
    }
}
