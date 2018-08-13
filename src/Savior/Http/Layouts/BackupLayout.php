<?php

declare(strict_types=1);

namespace Orchid\Savior\Http\Layouts;

use Orchid\Screen\Fields\TD;
use Orchid\Screen\Layouts\Table;

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
            TD::set('file_path', 'file_path'),
            TD::set('file_name', 'file_name'),
            TD::set('file_size', 'file_size'),
            TD::set('last_modified', 'last_modified'),
            TD::set('disk', 'disk'),
            TD::set('download', 'download'),
            TD::set('url', 'url'),
        ];
    }
}
