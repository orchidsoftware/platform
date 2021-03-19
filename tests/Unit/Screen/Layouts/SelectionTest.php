<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\App\Filters\HiddenFilter;
use Orchid\Tests\TestUnitCase;

class SelectionTest extends TestUnitCase
{
    public function testNoDisplayOnlyHiddenFilter()
    {
        $layout = LayoutFactory::selection([
            HiddenFilter::class,
        ]);

        $html = $layout->build(new Repository());

        $this->assertNull($html);
    }
}
