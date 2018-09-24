<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

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
            TD::set('log_name', 'log_name'),
            TD::set('description', 'description'),
            TD::set('countChanges', 'properties'),
            TD::set('created_at', 'created_at'),
        ];
    }
}
