<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Tests\App\Filters\NameFilter;
use Orchid\Tests\App\Filters\WithoutDisplayFilter;
use Orchid\Tests\TestUnitCase;

class FiltersTest extends TestUnitCase
{
    public function testSimpleValue()
    {
        request()->merge([
            'name' => 'Alexandr',
        ]);

        $value = (new NameFilter())->value();

        $this->assertEquals('Name: Alexandr', $value);
    }

    public function testMultipleValue()
    {
        request()->merge([
            'name' => [
                'Alexandr',
                'Alena',
            ],
        ]);

        $value = (new NameFilter())->value();

        $this->assertEquals('Name: Alexandr,Alena', $value);
    }

    public function testWithoutDisplayName()
    {
        $name = (new WithoutDisplayFilter())->name();

        $this->assertEquals('WithoutDisplayFilter', $name);
    }
}
