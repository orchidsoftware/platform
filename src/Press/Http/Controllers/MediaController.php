<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Support\Formats;

/**
 * Class MediaController.
 */
class MediaController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $directory = '';

    /**
     * @var \Illuminate\Config\Repository|mixed|string
     */
    private $disk;

    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.media');

        $this->disk = config('platform.disks.media', 'public');

        $this->filesystem = Storage::disk($this->disk);
    }

    /**
     * @param string $path
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($path = DIRECTORY_SEPARATOR)
    {
        $path = substr($path, 0) !== DIRECTORY_SEPARATOR ? $path.DIRECTORY_SEPARATOR : $path;
        $path = $path === DIRECTORY_SEPARATOR ? '' : $path;

        return view('platform::container.systems.media.index', [
            'name'        => trans('platform::systems/media.title'),
            'description' => trans('platform::systems/media.description'),
            'dir'         => $this->getDirPath($path),
            'files'       => $this->getFiles($path),
            'directories' => $this->getDirectories($path),
            'route'       => $path,
        ]);
    }

    /**
     * @param string $dir
     *
     * @return array
     */
    private function getDirPath(string $dir): array
    {
        $dirs = explode(DIRECTORY_SEPARATOR, $dir);

        return count($dirs) > 1 ? $dirs : [];
    }

    /**
     * @param string $dir
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFiles(string $dir): Collection
    {
        return $this->filesToFormat(collect($this->filesystem->files($dir)));
    }

    /**
     * @param string $dir
     *
     * @return \Illuminate\Support\Collection
     */
    private function getDirectories(string $dir): Collection
    {
        return $this->filesToFormat(collect($this->filesystem->directories($dir)));
    }

    /**
     * @param \Illuminate\Support\Collection $files
     *
     * @return \Illuminate\Support\Collection
     */
    private function filesToFormat(Collection $files): Collection
    {
        return $files->map(function ($file) {
            $modified = $this->filesystem->lastModified($file);
            $name = strpos($file, '/') > 1 ? str_replace('/', '', strrchr($file, '/')) : $file;

            return [
                'name'              => $name,
                'type'              => $this->filesystem->mimeType($file),
                'path'              => $this->filesystem->url($file),
                'size'              => $this->filesystem->size($file),
                'lastModified'      => Formats::toDateTimeString($modified),
            ];
        })->sortBy('name');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function newFolder(Request $request)
    {
        $new_folder = $request->new_folder;
        $success = false;
        $error = '';

        if ($this->filesystem->exists($new_folder)) {
            $error = trans('platform::systems/media.error_creating_folder');
        } elseif ($this->filesystem->makeDirectory($new_folder)) {
            $success = true;
        } else {
            $error = trans('platform::systems/media.error_creating_dir');
        }

        return compact('success', 'error');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function deleteFileFolder(Request $request)
    {
        $folderLocation = $request->folder_location;
        $fileFolder = $request->file_folder;
        $type = $request->type;
        $success = true;
        $error = '';

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";
        $fileFolder = "{$location}/{$fileFolder}";

        if ($type === 'folder') {
            if (! $this->filesystem->deleteDirectory($fileFolder)) {
                $error = trans('platform::systems/media.error_deleting_folder');
                $success = false;
            }
        } elseif (! $this->filesystem->delete($fileFolder)) {
            $error = trans('platform::systems/media.error_deleting_file');
            $success = false;
        }

        return compact('success', 'error');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllDirs(Request $request)
    {
        $folderLocation = $request->folder_location;

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";

        return response()->json(str_replace($location, '', $this->filesystem->directories($location)));
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function moveFile(Request $request)
    {
        $source = $request->source;
        $destination = $request->destination;
        $folderLocation = $request->folder_location;
        $success = false;

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";
        $source = "{$location}/{$source}";
        $destination = strpos($destination,
            '/../') !== false ? $this->directory.DIRECTORY_SEPARATOR.dirname($folderLocation).DIRECTORY_SEPARATOR.str_replace('/../',
                '', $destination) : "{$location}/{$destination}";

        $error = trans('platform::systems/media.error_already_exists');
        if (! file_exists($destination)) {
            $error = trans('platform::systems/media.error_moving');
            if ($this->filesystem->move($source, $destination)) {
                $success = true;
                $error = false;
            }
        }

        return compact('success', 'error');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function renameFile(Request $request)
    {
        $folderLocation = $request->folder_location;
        $filename = $request->filename;
        $newFilename = $request->new_filename;
        $success = false;

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";

        $error = trans('platform::systems/media.error_may_exist');
        if (! $this->filesystem->exists("{$location}/{$newFilename}")) {
            $error = trans('platform::systems/media.error_moving');
            if ($this->filesystem->move("{$location}/{$filename}", "{$location}/{$newFilename}")) {
                $success = true;
                $error = false;
            }
        }

        return compact('success', 'error');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            foreach ($request->files as $file) {
                $path = $file->move($this->filesystem->getDriver()->getAdapter()->applyPathPrefix(str_replace(',', '/', $request->upload_path)), $file->getClientOriginalName());
            }
            $success = true;
            $message = trans('platform::systems/media.success_uploaded_file');
        } catch (Exception $e) {
            $path = '';
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('success', 'message', 'path'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove()
    {
        try {
            return response()->json([
                'data' => [
                    'status'  => 200,
                    'message' => trans('platform::systems/media.image_removed'),
                ],
            ]);
        } catch (Exception $e) {
            $code = 500;
            $message = 'Internal error';

            if ($e->getCode()) {
                $code = $e->getCode();
            }

            if ($e->getMessage()) {
                $message = $e->getMessage();
            }

            return response()->json([
                'data' => [
                    'status'  => $code,
                    'message' => $message,
                ],
            ], $code);
        }
    }

    /**
     * @param string $path
     * @param string $delimiter
     *
     * @return array
     */
    public static function getBreadcrumb(string $path, string $delimiter = DIRECTORY_SEPARATOR): array
    {
        $breadcrumbs = array_filter(explode($delimiter, $path));

        return array_map(function ($item, $key, $path = '') use ($breadcrumbs, $delimiter) {
            foreach ($breadcrumbs as $bkey => $breadcrumb) {
                if ($bkey === $key) {
                    break;
                }
                $path = $path.$delimiter.$breadcrumb;
            }

            return [
                'name'   => $item,
                'path'   => empty($path) ? $item : $path.$delimiter.$item,
            ];
        }, $breadcrumbs, array_keys($breadcrumbs));
    }
}
