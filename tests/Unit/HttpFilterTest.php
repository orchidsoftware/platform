<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Http\Request;
use Orchid\Platform\Filters\HttpFilter;
use Orchid\Tests\TestUnitCase;

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
  }

  public function testHttpSortDESC()
  {
    $request = new Request([
      'sort' => 'foobar',
    ]);

    $filter = new HttpFilter($request);

    $this->assertEquals($filter->getSort('foo'), 'desc');
  }

}