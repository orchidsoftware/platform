<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class RowTest extends TestUnitCase
{
    public function testQueryVariables()
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $layout = Layout::rows([
            Input::make('name'),
        ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }
}
