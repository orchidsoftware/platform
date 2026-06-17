<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\RowDetail;
use Orchid\Screen\TD;

class RowDetailTable extends Table
{
    protected $target = 'items';

    protected function columns(): iterable
    {
        return [
            TD::make('id'),
            TD::make('name'),
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
