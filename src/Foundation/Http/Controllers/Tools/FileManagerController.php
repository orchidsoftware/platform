<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use DirectoryIterator;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Orchid\Foundation\Http\Controllers\Tools\FileFunctionsService as FileFunctionsFacade;

class FileManagerController extends BaseController
{
    /**
     * Public Storage.
     *
     * @var
     */
    protected $homePath;

    protected $publicPath;

    protected $exceptFiles = [];

    protected $exceptFolders = [];

    protected $exceptExtensions = [];

    public function __construct()
    {
        $this->homePath = public_path();
        $this->globalFilter = null;
    }

    /**
     * Show Home Files.
     *
     * @param CookieJar $cookieJar
     * @param Request   $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(CookieJar $cookieJar, Request $request)
    {
        //        $files = $this->getFiles($this->homePath, 'mime', 'all');
//        dump($files);
//        dd();

        return $this->firstViewThatExists('vendor/infinety/filemanager/index', 'dashboard::container.tools.filemanager.index');
    }

    /**
     * Allow replace the default views by placing a view with the same name.
     * If no such view exists, load the one from the package.
     *
     * @param $first_view
     * @param $second_view
     * @param array $information
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function firstViewThatExists($first_view, $second_view, $information = [])
    {
        // load the first view if it exists, otherwise load the second one
        if (view()->exists($first_view)) {
            return view($first_view, $information);
        } else {
            return view($second_view, $information);
        }
    }

    /**
     * Show FileManager dialog based.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDialog()
    {
        return $this->firstViewThatExists('vendor/infinety/filemanager/dialog', 'filemanager::dialog');
    }

    /**
     * Get ajax request to load files and folders.
     *
     * @param Request $request
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return string
     */
    public function ajaxGetFilesAndFolders(Request $request)
    {
        if ($request->ajax()) {
            $folder = $request->get('folder');
            if (!$folder) {
                $folder = $this->homePath;
            } else {
                $folder = $this->homePath.DIRECTORY_SEPARATOR.$folder;
            }

            //Se relative Path
            $this->setRelativePath($folder);

            $order = $request->get('sort');
            if (!$order) {
                $order = 'type';
            }
            $filter = $request->get('filter');
            if (!$filter) {
                $filter = false;
            }
            $files = $this->getFiles($folder, $order, $filter);

            return Response::json($this->firstViewThatExists('vendor/infinety/filemanager/render', 'filemanager::render', compact('files'))->render());

//            return json_encode($files);
        }
    }

    /**
     * Set Relative Path.
     *
     * @param $folder
     */
    private function setRelativePath($folder)
    {
        $home = explode('/', $this->homePath);
        $publicPath = str_replace($this->homePath, '', $folder);
        $append = $this->getAppend();
        if (last($home) != 'public') {
            $this->publicPath = $append.last($home).$publicPath;
        } else {
            $this->publicPath = $append.$publicPath;
        }
    }

    /**
     * Get Append to url.
     *
     * @return mixed|string
     */
    private function getAppend()
    {
        if (config('filemanager.appendUrl') != null) {
            return config('filemanager.appendUrl');
        } else {
            return '';
        }
    }

    /**
     * Get files from custom folder;.
     *
     * @param $folder
     * @param $order
     * @param bool $filter
     *
     * @return array
     */
    private function getFiles($folder, $order, $filter = false)
    {
        $permissions = $this->checkPerms($folder);
        if ($permissions == 400 || $permissions == 700) {
            return ['error' => "You don't have permissions to view this folder"];
        }

        $dir_iterator = new DirectoryIterator($folder);
        $files = [];
        foreach ($dir_iterator as $file) {
            if (!$file->isDot() && !$this->exceptExtensions->contains($file->getExtension()) && !$this->exceptFolders->contains($file->getBasename()) && !$this->exceptFiles->contains($file->getBasename()) && $this->accept($file)) {
                if ($file->isReadable()) {
                    $fileInfo = [
                        'name'       => trim($file->getBasename()),
                        'path'       => $file->getPath().'/'.$file->getBasename(),
                        'type'       => $file->getType(),
                        'mime'       => $this->getFileType($file),
                        'size'       => ($file->getSize() != 0) ? $file->getSize() : 0,
                        'size_human' => ($file->getSize() != 0) ? $this->formatBytes($file->getSize(), 0) : 0,
                        'thumb'      => asset($this->getThumb($file, $this->publicPath)),
                        'asset'      => url($this->publicPath.'/'.$file->getBasename()),
                        'can'        => true,
                    ];

                    if ($fileInfo['mime'] == 'image') {
                        list($width, $height) = getimagesize($fileInfo['path']);
                        $fileInfo['dimensions'] = $width.'x'.$height;
                    }

                    if ($file->getType() == 'dir') {
                        if ($file->isReadable()) {
                            $dataFolder = $this->readFolder($file->getPathname(), true);
                            $fileInfo['size'] = ($dataFolder->fileSum != 0) ? $this->formatBytes($dataFolder->fileSum, 1) : $fileInfo['size'];
                            $fileInfo['folder'] = (object) [
                                'path'        => str_replace($this->homePath.DIRECTORY_SEPARATOR, '', $file->getPathName()),
                                'fileCount'   => $dataFolder->fileCount,
                                'folderCount' => $dataFolder->folderCount,
                                'permission'  => true,
                            ];
                        } else {
                            $fileInfo['folder'] = (object) [
                                'path'       => str_replace($this->homePath.DIRECTORY_SEPARATOR, '', $file->getPathName()),
                                'permission' => false,
                            ];
                        }
                    }
                } else {
                    $fileInfo = [
                        'name' => trim($file->getBasename()),
                        'type' => $file->getType(),
                        'can'  => false,
                    ];
                    if ($file->getType() == 'dir') {
                        $fileInfo['folder'] = (object) [
                            'path'       => str_replace($this->homePath.DIRECTORY_SEPARATOR, '', $file->getPathName()),
                            'permission' => false,
                        ];
                    }
                }

                $files[] = (object) $fileInfo;
            }
        }
        $files = collect($files);
        if ($filter != false) {
            $files = $this->filterData($files, $filter);
        }

        return $this->orderData($files, $order);
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function checkPerms($path)
    {
        clearstatcache(null, $path);

        return decoct(fileperms($path) & 0777);
    }

    /**
     * @param $file
     *
     * @return bool
     */
    private function accept($file)
    {
        return '.' !== substr($file->current()->getFilename(), 0, 1);
    }

    /**
     * @param $file
     *
     * @return bool|string
     */
    private function getFileType($file)
    {
        $mime = File::mimeType($file->getPathname());

        if (str_contains($mime, 'directory')) {
            return 'dir';
        }

        if (str_contains($mime, 'image')) {
            return 'image';
        }

        if (str_contains($mime, 'pdf')) {
            return 'pdf';
        }

        if (str_contains($mime, 'audio')) {
            return 'audio';
        }

        if (str_contains($mime, 'video')) {
            return 'video';
        }

        if (str_contains($mime, 'zip')) {
            return 'file';
        }

        if (str_contains($mime, 'rar')) {
            return 'file';
        }

        if (str_contains($mime, 'octet-stream')) {
            return 'file';
        }

        if (str_contains($mime, 'excel')) {
            return 'text';
        }

        if (str_contains($mime, 'word')) {
            return 'text';
        }

        if (str_contains($mime, 'css')) {
            return 'text';
        }

        if (str_contains($mime, 'javascript')) {
            return 'text';
        }

        if (str_contains($mime, 'plain')) {
            return 'text';
        }

        if (str_contains($mime, 'rtf')) {
            return 'text';
        }

        if (str_contains($mime, 'text')) {
            return 'text';
        }

        return false;
    }

    /**
     * @param $size
     * @param int $level
     * @param int $precision
     * @param int $base
     *
     * @return string
     */
    private function formatBytes($size, $level = 0, $precision = 2, $base = 1024)
    {
        $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $times = floor(log($size, $base));

        return sprintf('%.'.$precision.'f', $size / pow($base, ($times + $level))).' '.$unit[$times + $level];
    }

    /**
     * Return the Type of file.
     *
     * @param $file
     * @param bool $folder
     *
     * @return bool|string
     */
    private function getThumb($file, $folder = false)
    {
        $mime = File::mimeType($file->getPathname());

        if (str_contains($mime, 'directory')) {
            return false;
        }

        if (str_contains($mime, 'image')) {
            if ($folder) {
                return $folder.DIRECTORY_SEPARATOR.$file->getBaseName();
            }

            return $file->getBaseName();
        }

        if (str_contains($mime, 'pdf')) {
            return 'filemanager_assets/img/pdf.png';
        }

        if (str_contains($mime, 'audio')) {
            return 'filemanager_assets/img/audio.png';
        }

        if (str_contains($mime, 'video')) {
            return 'filemanager_assets/img/video.png';
        }

        if (str_contains($mime, 'zip')) {
            return 'filemanager_assets/img/zip.png';
        }

        if (str_contains($mime, 'rar')) {
            return 'filemanager_assets/img/rar.png';
        }

        if (str_contains($mime, 'octet-stream')) {
            return 'filemanager_assets/img/compressed.png';
        }

        if (str_contains($mime, 'excel')) {
            return 'filemanager_assets/img/excel.png';
        }

        if (str_contains($mime, 'word') || $file->getExtension() == 'doc' || $file->getExtension() == 'docx') {
            return 'filemanager_assets/img/word.png';
        }

        if (str_contains($mime, 'css') || $file->getExtension() == 'css') {
            return 'filemanager_assets/img/css.png';
        }

        if (str_contains($mime, 'javascript') || $file->getExtension() == 'js' || $file->getExtension() == 'json') {
            return 'filemanager_assets/img/js.png';
        }

        // If no, return text file
        return 'filemanager_assets/img/text.png';
    }

    /**
     * Return a list of files and folders or count of them.
     *
     * @param $path
     * @param bool $onlyCounts
     *
     * @return array|\Illuminate\Support\Collection
     */
    private function readFolder($path, $onlyCounts = false)
    {
        $dir_iterator = new DirectoryIterator($path);
        $files = [];
        $filesCount = 0;
        $fileSizeSum = 0;
        $folderCount = 0;
        foreach ($dir_iterator as $file) {
            if (!$file->isDot() && !$this->exceptExtensions->contains($file->getExtension()) && !$this->exceptFolders->contains($file->getBasename()) && !$this->exceptFiles->contains($file->getBasename()) && $this->accept($file)) {
                if ($file->isReadable()) {
                    $fileInfo = [
                        'name' => $file->getBasename(),
                        'type' => $file->getType(),
                        'size' => $file->getSize(),
                    ];
                    $files[] = (object) $fileInfo;
                }
            }
        }

        if ($onlyCounts == true) {
            foreach ($files as $file) {
                if ($file->type == 'dir') {
                    $folderCount++;
                } else {
                    $filesCount++;
                    $fileSizeSum += $file->size;
                }
            }

            $files = (object) [
                'folderCount' => $folderCount,
                'fileCount'   => $filesCount,
                'fileSum'     => $fileSizeSum,
            ];
        }

        return $files;
    }

    /**
     * Filter data by custom type.
     *
     * @param $files
     * @param $filter
     *
     * @return mixed
     */
    private function filterData($files, $filter)
    {
        $folders = $files->where('type', 'dir');
        $items = $files->where('type', 'file');
        $filtered = $items->filter(function ($item) use ($filter) {
            switch ($filter) {
                case 'image':
                    if (str_contains($item->mime, 'image')) {
                        return $item;
                    }
                    break;
                case 'audio':
                    if (str_contains($item->mime, 'audio')) {
                        return $item;
                    }
                    break;
                case 'video':
                    if (str_contains($item->mime, 'video')) {
                        return $item;
                    }
                    break;
                case 'documents':
                    if (str_contains($item->mime, 'word') || str_contains($item->mime, 'excel') || str_contains($item->mime, 'pdf') || str_contains($item->mime, 'plain') || str_contains($item->mime, 'rtf') || str_contains($item->mime, 'text')) {
                        return $item;
                    }
                    break;
                case 'all':
                    return $item;
                    break;
            }
        });

        return $folders->merge($filtered);
    }

    /**
     * Order files and folders.
     *
     * @param $files
     * @param $order
     *
     * @return mixed
     */
    private function orderData($files, $order)
    {
        $folders = $files->where('type', 'dir');
        $items = $files->where('type', 'file');

        if ($order == 'size') {
            $folders = $folders->sortByDesc($order);
            $items = $items->sortByDesc($order);
        } else {
            // mb_strtolower to fix order by alpha
            $folders = $folders->sortBy(function ($item) {
                return mb_strtolower($item->name);
            })->values();

            $items = $items->sortBy(function ($item) {
                return mb_strtolower($item->name);
            })->values();
        }

        return $folders->merge($items);
    }

    /**
     * Upload the File.
     *
     * @param Request $request
     *
     * @return stringch
     */
    public function uploadFile(Request $request)
    {
        $data = FileFunctionsFacade::uploadFile($request['file'], $request['folder']);

        return $data;
    }

    /**
     * Create a new folder.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function createFolder(Request $request)
    {
        $data = FileFunctionsFacade::createFolder($request['name'], $request['folder']);

        return $data;
    }

    /**
     * Remove file or Folder recursively.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function delete(Request $request)
    {
        $data = FileFunctionsFacade::delete($request['data'], $request['folder'], $request['type']);

        return $data;
    }

    /**
     * Compress image. Only handles JPG or PNG files.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function optimize(Request $request)
    {
        $data = FileFunctionsFacade::optimize($request['file'], $request['type']);

        return $data;
    }

    /**
     * Download a file or Folder in zip.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function download(Request $request)
    {
        if ($request['type'] == 'file') {
            if ($request['name'] != null) {
                return response()->download($this->homePath.DIRECTORY_SEPARATOR.$request['path'], $request['name']);
            } else {
                return response()->download($this->homePath.DIRECTORY_SEPARATOR.$request['path']);
            }
        } elseif ($request['type'] == 'folder') {
            dd('HUI');
            $cleaned = explode('/', $request['name']);
            $cleaned = last($cleaned);
            $generatedZip = storage_path().'/filemanager/'.$cleaned.'.zip';
            $folder = $this->homePath.'/'.$request['path'].'/';
            Zipper::make($generatedZip)->add($folder)->close();
            $headers = [
                'Content-Type' => 'application/zip',
            ];
            if ($request['name'] != null) {
                return response()->download($generatedZip, $cleaned.'.zip', $headers)->deleteFileAfterSend(true);
            } else {
                return response()->download($generatedZip, 'folder.zip', $headers)->deleteFileAfterSend(true);
            }
        }

        return false;
    }

    /**
     * Return a file content if exists or false;.
     *
     * @param Request $request
     *
     * @return array
     */
    public function preview(Request $request)
    {
        if ($request->has('type') && $request->has('file')) {
            $type = $request['type'];
            $filename = $request['file'];
            if (file_exists($filename)) {
                if ($type == 'text') {
                    $lines = $this->getLines($filename);
                    $handle = fopen($filename, 'rw');
                    $size = filesize($filename);
                    $cutted = false;
                    if ($lines > 1000) {
                        $size = 12000;
                        $cutted = true;
                    }
                    $contents = fread($handle, $size);
                    $contents = ($cutted) ? $contents.PHP_EOL.PHP_EOL.'Important: File is too big. Has been cut!' : $contents;
                    fclose($handle);

                    $type = File::mimeType($filename);
                    $response = Response::make($contents, 200);
                    $response->header('Content-Type', $type);

                    return $response;
                }
            } else {
                return ['error' => 'File not exists'];
            }
        } else {
            return ['error' => 'Parameters needed'];
        }
    }

    /**
     * Get Lines of a file.
     *
     * @param $file
     *
     * @return int
     */
    private function getLines($file)
    {
        $f = fopen($file, 'rb');
        $lines = 0;
        while (!feof($f)) {
            $lines += substr_count(fread($f, 8192), "\n");
        }
        fclose($f);

        return $lines;
    }

    /**
     * Move a file to new destination.
     *
     * @param Request $request
     *
     * @return array
     */
    public function move(Request $request)
    {
        if ($request->has('oldFile')) {
            $oldFile = $this->homePath.DIRECTORY_SEPARATOR.$request->get('oldFile');
            if (!$request->has('newPath')) {
                $newPath = $this->homePath.DIRECTORY_SEPARATOR;
            } else {
                $newPath = $this->homePath.DIRECTORY_SEPARATOR.$request->get('newPath').DIRECTORY_SEPARATOR;
            }
            $fileName = explode('/', $request->get('oldFile'));
            $data = FileFunctionsFacade::rename($oldFile, $newPath, end($fileName), 'move');

            return $data;
        } else {
            return ['error' => 'Parameters needed'];
        }
    }

    public function rename(Request $request)
    {
        if ($request->has('type')) {
            if ($request->get('type') == 'file') {
                $fileName = explode('/', $request->get('file'));
                $fileName = end($fileName);
                $path = str_replace($fileName, '', $request->get('file'));
                $data = FileFunctionsFacade::rename($request->get('file'), $path, $request->get('newName'), 'rename');

                return $data;
            } else {
                $oldPath = $this->homePath.DIRECTORY_SEPARATOR.$request->get('file');
                $structure = explode('/', $request->get('file'));
                array_pop($structure);
                $newPath = $this->homePath.DIRECTORY_SEPARATOR.implode('/', $structure).DIRECTORY_SEPARATOR;
                $data = FileFunctionsFacade::rename($oldPath, $newPath, $request->get('newName'), 'rename', 'folder');

                return $data;
            }
        } else {
            return ['error' => 'Parameters needed'];
        }
    }
}
