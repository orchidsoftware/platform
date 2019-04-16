<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Http\Request;
use Orchid\Filters\Filterable;
use Orchid\Filters\HttpFilter;
use Orchid\Tests\TestUnitCase;
use Illuminate\Database\Eloquent\Model;
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

        $model = $this->getHttpModel();
        $sql = $model->filters($filter)->toSql();

        $this->assertStringContainsString('order by "foobar" asc', $sql);
    }

    public function testHttpFilter()
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

        $model = $this->getHttpModel();
        $sql = $model->filters($filter)->toSql();

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

        $model = $this->getHttpModel();
        $sql = $model->filters($filter)->toSql();

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
        $model = $this->getHttpModel();
        $sql = $model->filters($filter)->toSql();

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
     * @return Model
     */
    private function getHttpModel()
    {
        return new class extends Model {
            use Filterable;

            /**
             * @var
             */
            protected $allowedFilters = [
                'id',
                'status',
                'foo',
                'baz',
                'foobar',
            ];

            /**
             * @var
             */
            protected $allowedSorts = [
                'id',
                'status',
                'foo',
                'baz',
                'foobar',
            ];
        };
    }
}
