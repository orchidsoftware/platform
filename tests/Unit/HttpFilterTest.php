<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Tests\TestUnitCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class HttpFilterTest.
 */
class HttpFilterTest extends TestUnitCase
{
    public function testHttpIsSort(): void
    {
        $request = new Request([
            'sort' => 'foobar',
        ]);

        $filter = new HttpFilter($request);

        $this->assertTrue($filter->isSort('foobar'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('order by "foobar" asc', $sql);
    }

    public function testHttpFilterInteger(): void
    {
        $request = new Request([
            'filter' => [
                'foo' => '123',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals(123, $filter->getFilter('foo'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" = ?', $sql);
    }

    public function testHttpFilterLike(): void
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals('bar', $filter->getFilter('foo'));
        $this->assertEquals('qux', $filter->getFilter('baz'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" like ?', $sql);
        $this->assertStringContainsString('"baz" like ?', $sql);
    }

    public function testHttpFilterArray(): void
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar,qux',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals([
            'bar',
            'qux',
        ], $filter->getFilter('foo'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" in (?, ?)', $sql);
    }

    public function testHttpUnknownAttributes(): void
    {
        $request = new Request([
            'sort'   => 'unknown',
            'filter' => [
                'unknown' => 'not allow',
            ],
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringNotContainsStringIgnoringCase('order by "unknown"', $sql);
        $this->assertStringNotContainsStringIgnoringCase('"unknown" like ?', $sql);
    }

    public function testHttpSortDESC(): void
    {
        $request = new Request([
            'sort' => 'foobar',
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals('desc', $filter->getSort('foo'));
    }

    public function testHttpJSONFilter(): void
    {
        $request = new Request([
            'filter' => [
                'content.ru.name' => 'not allow',
            ],
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString("json_extract(\"content\", '$.\"ru\".\"name\"') like ?", $sql);
    }

    public function testHttpJSONSort(): void
    {
        $request = new Request([
            'sort' => 'content.ru.name',
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString("order by json_extract(\"content\", '$.\"ru\".\"name\"') asc", $sql);
    }

    public function testHttpJSONSortDesc(): void
    {
        $request = new Request([
            'sort' => '-content.ru.name',
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString("order by json_extract(\"content\", '$.\"ru\".\"name\"') desc", $sql);
    }

    public function testHttpSanitize(): void
    {
        $this->assertEquals('content->name', HttpFilter::sanitize('content->name'));
        $this->assertEquals('email', HttpFilter::sanitize('email'));
    }

    public function testHttpInjectedSQL(): void
    {
        $this->expectException(HttpException::class);

        HttpFilter::sanitize('email->"%27))%23injectedSQL');
    }

    /**
     * @param HttpFilter $filter
     *
     * @return Builder
     */
    private function getModelBuilder(HttpFilter $filter): Builder
    {
        $model = new class() extends Model {
            use Filterable;

            /**
             * @var array
             */
            protected $cast = [
                'content' => 'array',
            ];

            /**
             * @var array
             */
            protected $allowedFilters = [
                'id',
                'status',
                'foo',
                'baz',
                'foobar',
                'content',
            ];

            /**
             * @var array
             */
            protected $allowedSorts = [
                'id',
                'status',
                'foo',
                'baz',
                'foobar',
                'content',
            ];
        };

        return $model->filters($filter);
    }
}
