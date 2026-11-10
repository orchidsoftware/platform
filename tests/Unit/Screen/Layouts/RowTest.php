<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class RowTest extends TestUnitCase
{
    public function testQueryVariables(): void
    {
        $repository = new Repository([
            'name' => 'Alexandr Chernyaev',
        ]);

        $layout = Rows::make([
            Input::make('name'),
        ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }

    public function testTitleForShortRow(): void
    {
        $layout = Rows::make([])->title('Profile');

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile', $html);
    }

    public function testTitleForRow(): void
    {
        $rows = Rows::make([])->title('Profile');

        $html = $rows->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile', $html);
    }
}
