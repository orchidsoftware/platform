<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Http\Layouts\BackupLayout;
use Orchid\Screen\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Formats;

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
    public $permission = 'platform.systems.backups';

    /**
     * @var array
     */
    public $disk;

    /**
     * BackupScreen constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->disk = config('backup.backup.destination.disks', []);
    }

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
        return [
            BackupLayout::class,
        ];
    }

    /**
     * @return RedirectResponse
     */
    public function runBackup(): RedirectResponse
    {
        $queue = config('queue.default');

        if ($queue === 'sync' || $queue === 'null') {
            Alert::warning('Влючите очередь задач, что бы сделать резервную копию');
        } else {
            Alert::info('Зачада была добавлена в очередь');
            Artisan::queue('backup:run');
        }

        return back();
    }

    /**
     * @return array
     */
    private function getBackups(): array
    {
        foreach ($this->disk as $diskName) {
            $disk = Storage::disk($diskName);
            $files = $disk->allFiles();

            collect($files)
                ->filter(function ($file) {
                    // only take the zip files into account
                    return preg_match("/^(.*)(\d{4})-(\d{2})-(\d{2})-(\d{2})-(\d{2})-(\d{2}).zip$/", $file);
                })
                ->each(function ($file) use ($disk, $diskName, &$backups) {
                    // make an array of backup files, with their filesize and creation date
                    $backups[] = new Repository([
                        'path'          => $file,
                        'size'          => Formats::formatBytes($disk->size($file)),
                        'last_modified' => Carbon::createFromTimestamp($disk->lastModified($file))->diffForHumans(),
                        'disk'          => $diskName,
                        'url'           => $disk->url($file),
                    ]);
                });
        }

        // reverse the backups, so the newest one would be on top
        return array_reverse($backups ?? []);
    }
}
