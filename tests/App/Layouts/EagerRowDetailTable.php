<?php

namespace Orchid\Tests\App\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\RowDetail;
use Orchid\Screen\TD;

class EagerRowDetailTable extends Table
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
            ->render(fn (Repository $item, object $loop) => 'detail:'.$item->get('name').':'.$loop->index);
    }
}
