<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BackupLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'backups';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            TD::set('path', 'path')->setRender(function ($file) {
                return "<a href='{$file['url']}' target='_blank'>{$file['path']}</a>";
            }),
            TD::set('disk', 'disk'),
            TD::set('size', 'size'),
            TD::set('last_modified', 'last_modified'),
        ];
    }
}
