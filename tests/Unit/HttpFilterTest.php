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
    public function testHttpIsSort()
    {
        $request = new Request([
            'sort' => 'foobar',
        ]);

        $filter = new HttpFilter($request);

        $this->assertTrue($filter->isSort('foobar'));

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('order by "foobar" asc', $sql);
    }

    public function testHttpFilterInteger()
    {
        $request = new Request([
            'filter' => [
                'foo' => '123',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals($filter->getFilter('foo'), 123);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" = ?', $sql);
    }

    public function testHttpFilterLike()
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals($filter->getFilter('foo'), 'bar');
        $this->assertEquals($filter->getFilter('baz'), 'qux');

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" like ?', $sql);
        $this->assertStringContainsString('"baz" like ?', $sql);
    }

    public function testHttpFilterArray()
    {
        $request = new Request([
            'filter' => [
                'foo' => 'bar,qux',
            ],
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals($filter->getFilter('foo'), [
            'bar',
            'qux',
        ]);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString('"foo" in (?, ?)', $sql);
    }

    public function testHttpUnknownAttributes()
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

    public function testHttpSortDESC()
    {
        $request = new Request([
            'sort' => 'foobar',
        ]);

        $filter = new HttpFilter($request);

        $this->assertEquals($filter->getSort('foo'), 'desc');
    }

    public function testHttpJSONFilter()
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

    public function testHttpJSONSort()
    {
        $request = new Request([
            'sort' => 'content.ru.name',
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString("order by json_extract(\"content\", '$.\"ru\".\"name\"') asc", $sql);
    }

    public function testHttpJSONSortDesc()
    {
        $request = new Request([
            'sort' => '-content.ru.name',
        ]);

        $filter = new HttpFilter($request);

        $sql = $this->getModelBuilder($filter)->toSql();

        $this->assertStringContainsString("order by json_extract(\"content\", '$.\"ru\".\"name\"') desc", $sql);
    }

    public function testHttpSanitize()
    {
        $this->assertEquals(HttpFilter::sanitize('content->name'), 'content->name');
        $this->assertEquals(HttpFilter::sanitize('email'), 'email');
    }

    public function testHttpInjectedSQL()
    {
        $this->expectException(HttpException::class);

        HttpFilter::sanitize('email->"%27))%23injectedSQL');
    }

    /**
     * @param HttpFilter $filter
     *
     * @return Builder
     */
    private function getModelBuilder(HttpFilter $filter)
    {
        $model = new class extends Model {
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
