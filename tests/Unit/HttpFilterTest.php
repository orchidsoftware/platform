<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Filters\Types\Ilike;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereBetween;
use Orchid\Filters\Types\WhereDate;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Types\WhereIn;
use Orchid\Filters\Types\WhereMaxMin;
use Orchid\Tests\TestUnitCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class HttpFilterTest.
 */
class HttpFilterTest extends TestUnitCase
{
    public function test_http_is_sort(): void
    {
        request()->merge([
            'sort' => 'foobar',
        ]);

        $filter = new HttpFilter;
        $this->assertTrue($filter->isSort('foobar'));

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('order by "foobar" asc', $sql);
    }

    public function test_like(): void
    {
        request()->merge([
            'filter' => [
                'Like' => 'qux',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"Like" like ?', $sql);
    }

    public function test_ilike(): void
    {
        request()->merge([
            'filter' => [
                'Ilike' => 'qux',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"Ilike" ILIKE ?', $sql);
    }

    public function test_where_in(): void
    {
        request()->merge([
            'filter' => [
                'WhereIn' => 'bar,qux',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"WhereIn" in (?, ?)', $sql);

        request()->merge([
            'filter' => [
                'WhereIn' => ['bar', 'qux'],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"WhereIn" in (?, ?)', $sql);
    }

    public function test_where_between(): void
    {
        request()->merge([
            'filter' => [
                'WhereBetween' => [2, 10],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"WhereBetween" between ? and ?', $sql);
    }

    public function test_filter_range(): void
    {
        request()->merge([
            'filter' => [
                'WhereMaxMin' => ['min' => 1, 'max' => 5],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"WhereMaxMin" >= ? and "WhereMaxMin" <= ?', $sql);
    }

    public function test_filter_range_partial(): void
    {
        request()->merge([
            'filter' => [
                'WhereMaxMin' => ['min' => 1],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"WhereMaxMin" >= ?', $sql);
    }

    public function test_filter_date_range(): void
    {
        request()->merge([
            'filter' => [
                'WhereDateStartEnd' => ['start' => '2023-01-01', 'end' => '2023-02-01'],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('strftime(\'%Y-%m-%d\', "WhereDateStartEnd") >= cast(? as text) and strftime(\'%Y-%m-%d\', "WhereDateStartEnd") <= cast(? as text)', $sql);
    }

    public function test_filter_date_range_partial(): void
    {
        request()->merge([
            'filter' => [
                'WhereDateStartEnd' => ['start' => '2023-01-01'],
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('where strftime(\'%Y-%m-%d\', "WhereDateStartEnd") >= cast(? as text)', $sql);
    }

    public function test_multiple(): void
    {
        request()->merge([
            'filter' => [
                'Where'  => '42',
                'Like'   => '42',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString('"Where" = ?', $sql);
        $this->assertStringContainsString('"Like" like ?', $sql);
    }

    public function test_unknown_attributes(): void
    {
        request()->merge([
            'sort'   => 'unknown',
            'filter' => [
                'unknown' => 'not allow',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringNotContainsStringIgnoringCase('order by "unknown"', $sql);
        $this->assertStringNotContainsStringIgnoringCase('"unknown" like ?', $sql);
    }

    public function test_http_sort(): void
    {
        $filter = new HttpFilter(new Request([
            'sort' => 'foobar',
        ]));

        $this->assertEquals('asc', $filter->getSort('foobar'));

        $filter = new HttpFilter(new Request([
            'sort' => '-foobar',
        ]));

        $this->assertEquals('desc', $filter->getSort('foobar'));
    }

    /*
    public function testHttpJSONFilter(): void
    {
        request()->merge([
            'filter' => [
                'content.ru.name' => 'not allow',
            ],
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString("json_extract(\"content\", '$.\"ru\".\"name\"') like ?", $sql);
    }
    */

    public function test_nullable(): void
    {
        $filter = new HttpFilter(new Request([
            'filter' => [
                'Where'  => null,
            ],
        ]));

        $this->assertNull($filter->getFilter('Where'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringNotContainsString('"Where"', $sql);
    }

    public function test_json_sort(): void
    {
        request()->merge([
            'sort' => 'foobar.ru.name',
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString("order by json_extract(\"foobar\", '$.\"ru\".\"name\"') asc", $sql);

        request()->merge([
            'sort' => '-foobar.ru.name',
        ]);

        $sql = $this->getModelBuilder()->toSql();

        $this->assertStringContainsString("order by json_extract(\"foobar\", '$.\"ru\".\"name\"') desc", $sql);
    }

    public function test_http_sanitize(): void
    {
        $this->assertEquals('content->name', HttpFilter::sanitize('content->name'));
        $this->assertEquals('email', HttpFilter::sanitize('email'));
    }

    public function test_http_injected_sql(): void
    {
        $this->expectException(HttpException::class);

        HttpFilter::sanitize('email->"%27))%23injectedSQL');
    }

    private function getModelBuilder(?HttpFilter $filter = null): Builder
    {
        $model = new class extends Model
        {
            use Filterable;

            protected $allowedFilters = [
                'WhereIn'           => WhereIn::class,
                'Like'              => Like::class,
                'Ilike'             => Ilike::class,
                'Where'             => Where::class,
                'WhereBetween'      => WhereBetween::class,
                'WhereMaxMin'       => WhereMaxMin::class,
                'WhereDate'         => WhereDate::class,
                'WhereDateStartEnd' => WhereDateStartEnd::class,
            ];

            protected $allowedSorts = [
                'foobar',
            ];
        };

        return $model->filters(null, $filter);
    }
}
