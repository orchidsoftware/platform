<?php

namespace Orchid\Tests\Unit\Screen\Layouts;

use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Repository;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Tests\TestUnitCase;

class LegendTest extends TestUnitCase
{
    public function testCanSee(): void
    {
        $layout = new class extends Legend {
            protected $target = 'target';

            protected function columns(): array
            {
                return [];
            }

            public function isSee(): bool
            {
                return $this->query->get('visible');
            }
        };

        $empty = $layout->build(new Repository([
            'visible' => false,
            'target'  => [],
        ]));

        $this->assertEmpty($empty);

        $html = $layout->build(new Repository([
            'visible' => true,
            'target'  => [],
        ]))->render();

        $this->assertNotEmpty($html);
    }

    public function testBaseUsage(): void
    {
        $layout = Layout::legend('user', [
            Sight::make('name'),
        ]);

        $html = $layout->build(new Repository([
            'user' => new Repository([
                'name' => 'Alexandr Chernyaev',
            ]),
        ]))->render();

        $this->assertStringContainsString('Alexandr Chernyaev', $html);
    }
}
