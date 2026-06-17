<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Sortable;
use Orchid\Screen\Repository;
use Orchid\Screen\RowDetail;
use Orchid\Screen\Sight;

class EagerRowDetailSortable extends Sortable
{
    protected $target = 'target';

    protected function columns(): iterable
    {
        return [
            Sight::make('name'),
        ];
    }

    protected function detail(): ?RowDetail
    {
        return RowDetail::make()
            ->render(fn (Repository $item, object $loop) => 'detail:'.$item->get('name').':'.$loop->index);
    }
}
