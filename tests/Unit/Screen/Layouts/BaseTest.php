<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen\Layouts;

use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Repository;
use Orchid\Tests\TestUnitCase;

class BaseTest extends TestUnitCase
{
    public function testFindLayoutBySlugs(): void
    {
        $row = Layout::rows([
            Input::make('input'),
        ]);

        $layout = Layout::columns([
            Layout::tabs([
                'action 1' => Layout::collapse([$row]),
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
        $layout = new class() extends Base {
            /***
             * @param Repository $query
             *
             * @return bool
             */
            public function canSee(Repository $query): bool
            {
                return $query->get('show');
            }

            /**
             * @param Repository $repository
             *
             * @return mixed
             */
            public function build(Repository $repository)
            {
                if (! $this->checkPermission($this, $repository)) {
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

        $this->assertEquals($render, 'display');
    }
}
