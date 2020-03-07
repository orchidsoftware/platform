<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Tests\App\Components\Hello;
use Orchid\Tests\TestUnitCase;

class ComponentTest extends TestUnitCase
{
    public function testQueryVariables()
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $layout = Layout::component(Hello::class);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
        $this->assertStringContainsString($this->app->version(), $html);
    }
}
