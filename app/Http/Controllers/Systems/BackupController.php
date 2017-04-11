<?php

namespace Orchid\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local;
use Orchid\Http\Controllers\Controller;

class BackupController extends Controller
{
    /**
     * @var
     */
    public $data;

    /**
     * BackupController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.backup');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->data['backups'] = [];

        foreach (config('laravel-backup.backup.destination.disks') as $diskName) {
            $disk = Storage::disk($diskName);
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
                        'disk'          => $diskName,
                        'download'      => ($adapter instanceof Local) ? true : false,
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
     * Downloads a backup zip file.
     *
     * @param         $disk
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($disk, Request $request)
    {
        $disk = Storage::disk($disk);
        $fileName = urldecode($request->input('file_name'));
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storagePath = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($fileName)) {
                return response()->download($storagePath . $fileName);
            } else {
                abort(404, 'Бэкап не найден');
            }
        } else {
            abort(404, 'Невозможно скачать с внешних ресурсов');
        }
    }
}
