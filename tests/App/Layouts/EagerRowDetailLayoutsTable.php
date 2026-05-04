<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\RowDetail;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class EagerRowDetailLayoutsTable extends Table
{
    protected $target = 'target';

    protected function columns(): array
    {
        return [
            TD::make('name'),
        ];
    }

    protected function detail(): ?RowDetail
    {
        return RowDetail::make()
            ->repository(fn (Repository $item) => [
                'name' => 'detail '.$item->get('name'),
            ])
            ->layouts([
                Layout::legend('', [
                    Sight::make('name'),
                ]),
            ]);
    }
}
