<?php

declare(strict_types=1);

namespace Orchid\Savior\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Savior\Http\Layouts\BackupLayout;

class AnnouncementScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Анонсы';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Обявления ресурса';

    /**
     * @var string
     */
    //public $permission = 'platform.savior.backups';


    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'backups' => $this->getBackups(),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Сделать резервную копию')
                ->method('runBackup'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [];
    }

}
