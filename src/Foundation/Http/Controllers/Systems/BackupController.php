<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Orchid\Foundation\Http\Requests\Request;

class BackupController extends Controller
{
    /**
     * @var
     */
    public $data;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->data['backups'] = [];

        foreach (config('laravel-backup.backup.destination.disks') as $disk_name) {
            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $file) {
                // only take the zip files into account
                if (substr($file, -4) == '.zip' && $disk->exists($file)) {
                    $this->data['backups'][] = [
                        'file_path'     => $file,
                        'file_name'     => str_replace('backups/', '', $file),
                        'file_size'     => $disk->size($file),
                        'last_modified' => $disk->lastModified($file),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof \League\Flysystem\Adapter\Local) ? true : false,
                    ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';

        return view('dashboard::container.systems.backup.index', $this->data);
    }

    /**
     * @return string
     */
    public function create()
    {
        if (config('queue.default' !== 'sync')) {
            Artisan::queue('backup:run');

            return response()->json([
                'title'   => 'В очереди',
                'message' => 'Бэкап поставлен в очередь и будет создан в ближайшее время',
                'type'    => 'success',
            ]);
        }

        return response()->json([
            'title'   => 'Не поддерживается',
            'message' => 'Для ручного создания бэкапа необходимо включить поддежку очереди',
            'type'    => 'error',
        ]);
    }

    /**
     * Downloads a backup zip file.
     * @param Request $request
     * @return
     */
    public function download(Request $request)
    {
        $disk = Storage::disk($request->input('disk'));
        $file_name = $request->input('file_name');
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof \League\Flysystem\Adapter\Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, 'Бэкап не найден');
            }
        } else {
            abort(404, 'Невозможно скачать с внешних ресурсов');
        }
    }

    /**
     * Deletes a backup file.
     *
     * @param $file_name
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($file_name)
    {
        $disk = Storage::disk(\Request::input('disk'));

        if ($disk->exists($file_name)) {
            $disk->delete($file_name);

            return response()->json([
                'title'   => 'Объект удалён',
                'message' => 'Бэкап был успешно удалён',
                'type'    => 'success',
            ]);
        } else {
            abort(404, 'Бэкап не найден');
        }
    }
}
