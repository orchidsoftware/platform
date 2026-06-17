<?php

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Screen;
use Orchid\Tests\App\Layouts\RowDetailSortable;
use Orchid\Tests\App\Layouts\RowDetailTable;
use Orchid\Tests\App\RowDetailItem;

class RowDetailScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'items' => [
                new RowDetailItem(['id' => 100, 'name' => 'First']),
                new RowDetailItem(['id' => 200, 'name' => 'Second']),
            ],
        ];
    }

    public function layout(): iterable
    {
        return [
            new RowDetailTable,
            new RowDetailSortable,
        ];
    }

    public function asyncItemDetail(int $item): array
    {
        return [
            'name' => "Item {$item}",
        ];
    }
}
