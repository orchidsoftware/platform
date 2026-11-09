<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\AllowedFilters;
use Orchid\Filters\AllowedSorts;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Tests\TestUnitCase;

class FilterAttributesTest extends TestUnitCase
{
    public function testFiltersAndSortsAreInheritedThroughMultipleLevels(): void
    {
        request()->merge(['filter' => ['name' => 'Taylor'], 'sort' => '-id']);

        $query = (new InheritedFilterModel)->filters();

        $this->assertSame('select * from "users" where "name" like ? order by "id" desc', $query->toSql());
        $this->assertSame(['%Taylor%'], $query->getBindings());
    }

    public function testChildFiltersReplaceParentFiltersAndKeepInheritedSorts(): void
    {
        request()->merge(['filter' => ['id' => 1, 'email' => 'taylor@example.com'], 'sort' => 'name']);

        $query = (new ReplacedFiltersModel)->filters();

        $this->assertSame('select * from "users" where "email" = ? order by "name" asc', $query->toSql());
        $this->assertSame(['taylor@example.com'], $query->getBindings());
    }

    public function testChildSortsReplaceParentSortsAndKeepInheritedFilters(): void
    {
        request()->merge(['filter' => ['name' => 'Taylor'], 'sort' => ['id', '-email']]);

        $query = (new ReplacedSortsModel)->filters();

        $this->assertSame('select * from "users" where "name" like ? order by "email" desc', $query->toSql());
        $this->assertSame(['%Taylor%'], $query->getBindings());
    }

    public function testEmptyFiltersDisableInheritedFiltersWithoutDisablingSorts(): void
    {
        request()->merge(['filter' => ['id' => 1], 'sort' => '-name']);

        $query = (new EmptyFiltersModel)->filters();

        $this->assertSame('select * from "users" order by "name" desc', $query->toSql());
        $this->assertSame([], $query->getBindings());
    }

    public function testEmptyAttributesDisableBothInheritedLists(): void
    {
        request()->merge(['filter' => ['id' => 1], 'sort' => 'name']);

        $query = (new EmptyFilterOptionsModel)->filters();

        $this->assertSame('select * from "users"', $query->toSql());
        $this->assertSame([], $query->getBindings());
    }

    public function testEmptySortsDisableInheritedSortsWithoutDisablingFilters(): void
    {
        request()->merge(['filter' => ['id' => 1], 'sort' => 'name']);

        $query = (new EmptySortsModel)->filters();

        $this->assertSame('select * from "users" where "id" = ?', $query->toSql());
        $this->assertSame([1], $query->getBindings());
    }

    public function testMissingAttributesAllowNoFiltersOrSorts(): void
    {
        request()->merge(['filter' => ['id' => 1], 'sort' => 'name']);

        $query = (new UnconfiguredFilterModel)->filters();

        $this->assertSame('select * from "users"', $query->toSql());
        $this->assertSame([], $query->getBindings());
    }

    public function testUndeclaredColumnsCannotBeFilteredOrSorted(): void
    {
        request()->merge(['filter' => ['password' => 'secret'], 'sort' => '-password']);

        $query = (new AttributedFilterModel)->filters();

        $this->assertSame('select * from "users"', $query->toSql());
        $this->assertSame([], $query->getBindings());
    }
}

class UnconfiguredFilterModel extends Model
{
    use Filterable;

    protected $table = 'users';
}

#[AllowedFilters(['id' => Where::class, 'name' => Like::class])]
#[AllowedSorts(['id', 'name'])]
class AttributedFilterModel extends UnconfiguredFilterModel {}

class ChildFilterModel extends AttributedFilterModel {}

class InheritedFilterModel extends ChildFilterModel {}

#[AllowedFilters(['email' => Where::class])]
class ReplacedFiltersModel extends AttributedFilterModel {}

#[AllowedSorts(['email'])]
class ReplacedSortsModel extends AttributedFilterModel {}

#[AllowedFilters([])]
class EmptyFiltersModel extends AttributedFilterModel {}

#[AllowedSorts([])]
class EmptySortsModel extends AttributedFilterModel {}

#[AllowedFilters([])]
#[AllowedSorts([])]
class EmptyFilterOptionsModel extends AttributedFilterModel {}
