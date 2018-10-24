<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class HistoryLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'history';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::set('log_name'),
            TD::set('description'),
            TD::set('countChanges'),
            TD::set('created_at'),
        ];
    }
}
