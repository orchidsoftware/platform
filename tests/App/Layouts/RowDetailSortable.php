<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Repository;
use Orchid\Screen\RowDetail;
use Orchid\Screen\Sight;

class RowDetailSortable extends Sortable
{
    protected $target = 'items';

    protected function columns(): iterable
    {
        return [
            Sight::make('name'),
        ];
    }

    protected function detail(): ?RowDetail
    {
        return RowDetail::make()
            ->deferred('asyncItemDetail')
            ->parameters(fn (Repository $item) => ['item' => $item->get('id')])
            ->render(fn (Repository $item) => 'Async detail '.$item->get('name'));
    }
}
