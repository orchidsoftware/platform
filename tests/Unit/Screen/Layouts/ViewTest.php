<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class ViewTest extends TestUnitCase
{
    public function testRepositoryValuesOverrideArrayableViewDefaults(): void
    {
        $layout = LayoutFactory::view('exemplar::layouts.wrapper', collect(['name' => 'Taylor']));

        $this->assertStringContainsString('Hello Taylor', $layout->build(new Repository)->render());
        $this->assertStringContainsString('Hello Alex', $layout->build(new Repository(['name' => 'Alex']))->render());
    }
}
