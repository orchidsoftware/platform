<?php

namespace Orchid\Platform\Http\Controllers\Systems;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * @var string
     */
    private $filesystem;

    /**
     * @var string
     */
    private $directory = '';

    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $this->filesystem = config('platform.disks.media', 'public');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard::container.systems.media.index');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function files(Request $request)
    {
        $folder = $request->folder;

        if ($folder == DIRECTORY_SEPARATOR) {
            $folder = '';
        }

        $dir = $this->directory.$folder;

        $extensions = $request->get('mime', null);

        return response()->json([
            'name'          => 'files',
            'type'          => 'folder',
            'path'          => $dir,
            'folder'        => $folder,
            'items'         => $this->getFiles($dir, $extensions),
            'last_modified' => 'asdf',
        ]);
    }

    /**
     * @param      $dir
     * @param null $mime
     *
     * @return array
     */
    private function getFiles($dir, $mime = null)
    {
        $files = [];
        $storageFiles = Storage::disk($this->filesystem)->files($dir);
        $storageFolders = Storage::disk($this->filesystem)->directories($dir);

        foreach ($storageFiles as $file) {
            $mimetype = Storage::disk($this->filesystem)->mimeType($file);
            if ($mime && strpos($mimetype, $mime) === false) {
                continue;
            }

            $files[] = [
                'name'          => strpos($file, '/') > 1 ? str_replace('/', '', strrchr($file, '/')) : $file,
                'type'          => $mimetype,
                'path'          => Storage::disk($this->filesystem)->url($file),
                'size'          => Storage::disk($this->filesystem)->size($file),
                'last_modified' => Storage::disk($this->filesystem)->lastModified($file),
            ];
        }

        foreach ($storageFolders as $folder) {
            $files[] = [
                'name'          => strpos($folder, '/') > 1 ? str_replace('/', '', strrchr($folder, '/')) : $folder,
                'type'          => 'folder',
                'path'          => Storage::disk($this->filesystem)->url($folder),
                'items'         => '',
                'last_modified' => '',
            ];
        }

        return $files;
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

        if (Storage::disk($this->filesystem)->exists($new_folder)) {
            $error = 'Sorry that folder already exists, please delete that folder if you wish to re-create it';
        } elseif (Storage::disk($this->filesystem)->makeDirectory($new_folder)) {
            $success = true;
        } else {
            $error = 'Sorry something seems to have gone wrong with creating the directory, please check your permissions';
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

        if ($type == 'folder') {
            if (! Storage::disk($this->filesystem)->deleteDirectory($fileFolder)) {
                $error = 'Sorry something seems to have gone wrong when deleting this folder, please check your permissions';
                $success = false;
            }
        } elseif (! Storage::disk($this->filesystem)->delete($fileFolder)) {
            $error = 'Sorry something seems to have gone wrong deleting this file, please check your permissions';
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

        return response()->json(str_replace($location, '', Storage::disk($this->filesystem)->directories($location)));
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
        $error = '';

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";
        $source = "{$location}/{$source}";
        $destination = strpos($destination,
            '/../') !== false ? $this->directory.DIRECTORY_SEPARATOR.dirname($folderLocation).DIRECTORY_SEPARATOR.str_replace('/../',
                '', $destination) : "{$location}/{$destination}";

        if (! file_exists($destination)) {
            if (Storage::disk($this->filesystem)->move($source, $destination)) {
                $success = true;
            } else {
                $error = 'Sorry there seems to be a problem moving that file/folder, please make sure you have the correct permissions.';
            }
        } else {
            $error = 'Sorry there is already a file/folder with that existing name in that folder.';
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
        $error = false;

        if (is_array($folderLocation)) {
            $folderLocation = rtrim(implode(DIRECTORY_SEPARATOR, $folderLocation), DIRECTORY_SEPARATOR);
        }

        $location = "{$this->directory}/{$folderLocation}";

        if (! Storage::disk($this->filesystem)->exists("{$location}/{$newFilename}")) {
            if (Storage::disk($this->filesystem)->move("{$location}/{$filename}", "{$location}/{$newFilename}")) {
                $success = true;
            } else {
                $error = 'Sorry there seems to be a problem moving that file/folder, please make sure you have the correct permissions.';
            }
        } else {
            $error = 'File or Folder may already exist with that name. Please choose another name or delete the other file.';
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
                $path = $file->move(Storage::disk($this->filesystem)->getDriver()->getAdapter()->getPathPrefix(), $file->getClientOriginalName().'.'.$file->getClientOriginalExtension());
            }
            $success = true;
            $message = 'Successfully uploaded new file!';
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
                    'message' => 'Image removed',
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
}
