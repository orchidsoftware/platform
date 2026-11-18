<?php

declare(strict_types=1);

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
        $layout = new class extends Legend
        {
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

    public function testTitle(): void
    {
        $layout = new class extends Legend
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [
                    Sight::make('name'),
                ];
            }
        };

        $layout->title('User Information');

        $html = $layout->build(new Repository([
            'target' => new Repository([
                'name' => 'Alexandr',
            ]),
        ]))->render();

        $this->assertStringContainsString('User Information', $html);
    }

    public function testColumnsFilteredBySee(): void
    {
        $layout = new class extends Legend
        {
            protected $target = 'target';

            protected function columns(): array
            {
                return [
                    Sight::make('visible'),
                    Sight::make('hidden')->canSee(false),
                ];
            }
        };

        $html = $layout->build(new Repository([
            'target' => new Repository([
                'visible' => 'shown',
                'hidden'  => 'hidden',
            ]),
        ]))->render();

        $this->assertStringContainsString('shown', $html);
    }

    public function testNoTargetUsesRepositoryDirectly(): void
    {
        $layout = new class extends Legend
        {
            protected function columns(): array
            {
                return [
                    Sight::make('name'),
                ];
            }
        };

        $html = $layout->build(new Repository([
            'name' => 'No Target',
        ]))->render();

        $this->assertStringContainsString('No Target', $html);
    }
}
