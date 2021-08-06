<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Platform\Models\User;
use Orchid\Tests\App\Filters\EmailFilter;
use Orchid\Tests\App\Filters\NameFilter;
use Orchid\Tests\App\Layouts\GroupNameAndEmail;
use Orchid\Tests\TestUnitCase;

class FiltersTest extends TestUnitCase
{

    public function testNotParamsFiltersApply(): void
    {
        $sql = User::filtersApply([
            NameFilter::class,
            EmailFilter::class,
        ])->toSql();

        $this->assertEquals('select * from "users"', $sql);
    }

    public function testOnlyOneParamsFiltersApply(): void
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

    public function testManyParamsFiltersApply(): void
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


    public function testManyParamsFiltersApplyWithHttpAndDefaultSort(): void
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

    public function testDefaultSort(): void
    {
        $sql = User::filters()->defaultSort('created_at')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" asc', $sql);

        $sql = User::filters()->defaultSort('created_at', 'desc')->toSql();

        $this->assertEquals('select * from "users" order by "created_at" desc', $sql);
    }

    public function testDefaultSortWithParams(): void
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

    public function testFiltersApplySomeSelection()
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
}
