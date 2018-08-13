<?php

declare(strict_types=1);

namespace Orchid\Savior\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Alert;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Orchid\Savior\Http\Layouts\BackupLayout;

class BackupScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Резервные копии';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Резервные копии';

    /**
     * @var string
     */
    public $permission = 'platform.savior.backups';

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
            Link::name('Сделать резервную копию')->method('runBackup'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            BackupLayout::class,
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function runBackup()
    {
        $queue = config('queue.default');

        if ($queue === 'sync' || $queue === 'null') {
            Alert::info('Влючите очередь задач, что бы сделать резервную копию');
        } else {
            Artisan::queue('backup:run');
        }

        return back();
    }

    /**
     * @return array
     */
    private function getBackups()
    {
        $backups = [];
        foreach (config('backup.backup.destination.disks') as $diskName) {
            $disk = Storage::disk($diskName);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();
            // make an array of backup files, with their filesize and creation date
            foreach ($files as $file) {
                // only take the zip files into account
                if (substr($file, -4) == '.zip' && $disk->exists($file)) {
                    $backups[] = new Repository([
                        'file_path'     => $file,
                        'file_name'     => str_replace('backups/', '', $file),
                        'file_size'     => $disk->size($file),
                        'last_modified' => $disk->lastModified($file),
                        'disk'          => $diskName,
                        'download'      => $adapter instanceof Local,
                        'url'           => $disk->url($file),
                    ]);
                }
            }
        }
        // reverse the backups, so the newest one would be on top
        return array_reverse($backups);
    }
}
