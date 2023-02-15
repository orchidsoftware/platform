<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class LayoutTest extends TestUnitCase
{
    public function testFindLayoutBySlugs(): void
    {
        $row = LayoutFactory::rows([
            Input::make('input'),
        ]);

        $layout = LayoutFactory::columns([
            LayoutFactory::tabs([
                'action 1' => LayoutFactory::accordion([$row]),
                'action 2' => $row,
            ]),
        ]);

        $find = $layout->findBySlug($row->getSlug());
        $this->assertEquals($row, $find);

        $find = $layout->findBySlug(Str::random());
        $this->assertNull($find);
    }

    public function testCanSeeLayout(): void
    {
        $layout = new class() extends Layout
        {
            /***
             * @return bool
             */
            public function isSee(): bool
            {
                return $this->query->get('show');
            }

            /**
             * @return mixed
             */
            public function build(Repository $repository)
            {
                $this->query = $repository;

                if (! $this->isSee()) {
                    return;
                }

                return 'display';
            }
        };

        $render = $layout->build(new Repository([
            'show' => false,
        ]));

        $this->assertNull($render);

        $render = $layout->build(new Repository([
            'show' => true,
        ]));

        $this->assertEquals('display', $render);
    }
}
