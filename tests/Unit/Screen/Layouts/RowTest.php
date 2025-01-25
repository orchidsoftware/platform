<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\LayoutFactory;
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

        $layout = LayoutFactory::rows([
            Input::make('name'),
        ]);

        $html = $layout->build($repository)->withErrors([])->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }

    public function testTitleForShortRow(): void
    {
        $layout = LayoutFactory::rows([])->title('Profile');

        $html = $layout->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile', $html);
    }

    public function testTitleForRow(): void
    {
        $rows = new class extends Rows
        {
            protected ?string $title = 'Profile';

            protected function fields(): array
            {
                return [];
            }
        };

        $html = $rows->build(new Repository)
            ->withErrors([])
            ->render();

        $this->assertStringContainsString('Profile', $html);
    }
}
