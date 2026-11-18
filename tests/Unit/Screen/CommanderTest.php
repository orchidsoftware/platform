<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Concerns\HasCommandBar;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

/**
 * Class CommanderTest.
 */
class CommanderTest extends TestUnitCase
{
    public function getCommandClass(): object
    {
        return new class
        {
            use HasCommandBar {
                buildCommandBar as public;
            }

            /**
             * @return Action[]
             */
            protected function commandBar(): array
            {
                return [
                    Link::make('show')->canSee(true),
                    Link::make('hide')->canSee(false),
                ];
            }
        };
    }

    public function testCountCommandItems(): void
    {
        $command = $this->getCommandClass();

        $this->assertCount(1, $command->buildCommandBar(new Repository));
    }
}
