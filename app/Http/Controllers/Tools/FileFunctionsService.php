<?php

namespace Orchid\Http\Controllers\Tools;

use Symfony\Component\HttpFile\UploadedFile;

class FileFunctionsService
{
    /**
     * Home Path.
     *
     * @var
     */
    protected $path;

    /**
     * FileUploadService constructor.
     */
    public function __construct()
    {
        $this->path = config('filemanager.homePath');
    }

    /**
     * Handles Upload File Method.
     *
     * @param UploadedFile|null $file
     * @param $folder
     *
     * @return stringch
     */
    public static function uploadFile(UploadedFile $file = null, $folder)
    {
        $result = self::upload($file, $folder);

        return $result;
    }

    /**
     * Handles Upload files.
     *
     * @param UploadedFile $file
     * @param $folder
     *
     * @return stringch
     */
    private static function upload(UploadedFile $file, $folder)
    {
        $originalName = $file->getClientOriginalName();
        $originalNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $newName = self::sanitize($originalNameWithoutExt).'.'.$file->getClientOriginalExtension();
        $path = self::path.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR;

//        $this->checkFileExists($path,$newName);

        $name = (!self::checkFileExists($path, $newName)) ? $newName : self::checkFileExists($path, $newName);

        if (!is_writable($path)) {
            return ['error' => 'This folder is not writable'];
        }

        if ($file->move($path, $name)) {

            //Try to compress
            if (config('filemanager.optimizeImages') == true) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);

                if (config('filemanager.pngquantPath') != null) {
                    //Compress PNG files
                    if ($ext == 'png') {
                        $compressed_png_content = self::compress_png($path.$name);
                        if ($compressed_png_content != false) {
                            file_put_contents($path.$name, $compressed_png_content);
                        }
                    }
                }

                if (config('filemanager.jpegRecompressPath') != null) {
                    //Compress JPG files
                    if ($ext == 'jpg' || $ext == 'jpeg') {
                        $compressed_jpg_content = self::compress_jpg($path.$name);

                        if ($compressed_jpg_content != false) {
                            file_put_contents($path.$name, $compressed_jpg_content);
                        }
                    }
                }
            }

            return ['success' => $name];
        } else {
            return ['error' => 'Impossible upload this file to this folder'];
        }
    }

    /**
     * @param $string
     * @param bool $force_lowercase
     * @param bool $anal
     *
     * @return bool|mixed|string
     */
    private static function sanitize($string, $force_lowercase = true, $anal = true)
    {
        $strip = ['~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '=', '+', '[', '{', ']',
            '}', '\\', '|', ';', ':', '"', "'", '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;',
            'â€”', 'â€“', ',', '<', '.', '>', '/', '?', ];
        $clean = trim(str_replace($strip, '-', strip_tags($string)));
        $clean = preg_replace('/\s+/', '-', $clean);
        $clean = ($anal) ? preg_replace('/[^a-zA-Z0-9]/', '-', $clean) : $clean;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    /**
     * Check if file is on server and returns the name of file plus counter.
     *
     * @param $folder
     * @param $name
     *
     * @return bool|string
     */
    private static function checkFileExists($folder, $name)
    {
        if (file_exists($folder.$name)) {
            $withoutExt = pathinfo($name, PATHINFO_FILENAME);
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $i = 1;
            while (file_exists($folder.$withoutExt.'-'.$i.'.'.$ext)) {
                $i++;
            }

            return $withoutExt.'-'.$i.'.'.$ext;
        }

        return false;
    }

    /**
     * Optimizes PNG file with pngquant 1.8 or later (reduces file size of 24-bit/32-bit PNG images).
     *
     * You need to install pngquant 1.8 on the server (ancient version 1.0 won't work).
     * There's package for Debian/Ubuntu and RPM for other distributions on http://pngquant.org
     *
     * @param $path_to_png_file string - path to any PNG file, e.g. $_FILE['file']['tmp_name']
     * @param $max_quality int - conversion quality, useful values from 60 to 100 (smaller number = smaller file)
     *
     * @return string - content of PNG file after conversion
     */
    public static function compress_png($path_to_png_file, $max_quality = 90)
    {
        if (!file_exists($path_to_png_file)) {
            return false;
        }

        // guarantee that quality won't be worse than that.
        $min_quality = 60;

        // '-' makes it use stdout, required to save to $compressed_png_content variable
        // '<' makes it read from the given file path
        // escapeshellarg() makes this safe to use with any path
        $compressed_png_content = shell_exec(config('filemanager.pngquantPath')." --quality=$min_quality-$max_quality - < ".escapeshellarg($path_to_png_file));

        if (!$compressed_png_content) {
            return false;
        }

        return $compressed_png_content;
    }

    /**
     * Optimizes JPG file with jpg-recompress.
     *
     * @param [type] $path_to_jpg_file [description]
     * @param int    $max_quality      [description]
     *
     * @return bool|string [type] [description]
     */
    public static function compress_jpg($path_to_jpg_file, $max_quality = 90)
    {
        if (!file_exists($path_to_jpg_file)) {
            return false;
        }

        // guarantee that quality won't be worse than that.
        $min_quality = 60;

        // '- -' makes it use stdout, required to save to $compressed_jpg_content variable
        // '<' makes it read from the given file path
        // escapeshellarg() makes this safe to use with any path
        $compressed_jpg_content = shell_exec(config('filemanager.jpegRecompressPath')." --quality high --min $min_quality --max $max_quality --quiet - - < ".escapeshellarg($path_to_jpg_file));

        if (!$compressed_jpg_content) {
            return false;
        }

        return $compressed_jpg_content;
    }

    /**
     * Creates new folder on path.
     *
     * @param $newName
     * @param $currentFolder
     *
     * @return array
     */
    public static function createFolder($newName, $currentFolder)
    {
        $path = self::path.DIRECTORY_SEPARATOR.$currentFolder.DIRECTORY_SEPARATOR;
        if (!is_writable($path)) {
            return ['error' => 'This folder is not writable'];
        }

        if (self::checkFolderExists($path.$newName)) {
            return ['error' => 'This folder already exists'];
        }

        try {
            mkdir($path.$newName, 0755);

            return ['success' => 'Folder '.$newName.' created successfully'];
        } catch (\Exception $e) {
            return ['error' => 'Error creating folder'];
        }
    }

    /**
     * Check if folder exists.
     *
     * @param $folder
     *
     * @return bool
     */
    private static function checkFolderExists($folder)
    {
        if (file_exists($folder)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Move or rename a file or folder.
     *
     * @param $oldFile
     * @param $newPath
     * @param $name
     * @param $type
     * @param string $fileOrFolder
     *
     * @return array
     */
    public static function rename($oldFile, $newPath, $name, $type, $fileOrFolder = 'file')
    {
        $permissions = self::checkPerms($newPath);
        if ($permissions == 400 || $permissions == 700) {
            return ['error' => "You don't have permissions to move to this folder"];
        }

        $name = self::checkValidNameOption($name, $fileOrFolder);

        $name = (!self::checkFileExists($newPath, $name)) ? $name : self::checkFileExists($newPath, $name);

        if (rename($oldFile, $newPath.$name)) {
            if ($type = 'rename') {
                return ['success' => ucfirst($fileOrFolder).' '.$name.' renamed successfully'];
            } else {
                return ['success' => ucfirst($fileOrFolder).' '.$name.' moved successfully'];
            }
        } else {
            return ['error' => 'Error moving this file'];
        }
    }

    /**
     * Check permissions of folder.
     *
     * @param $path
     *
     * @return string
     */
    private static function checkPerms($path)
    {
        clearstatcache(null, $path);

        return decoct(fileperms($path) & 0777);
    }

    /**
     * Check if validName option is true and then sanitize new string.
     *
     * @param string $name
     * @param string $folder
     *
     * @return string
     */
    private static function checkValidNameOption($name, $folder)
    {
        if (config('filemanager.validName') == true) {
            if ($folder == 'file') {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $name = pathinfo($name, PATHINFO_FILENAME);

                return self::sanitize($name).'.'.$ext;
            } else {
                return self::sanitize($name);
            }
        } else {
            return $name;
        }
    }

    /*********************************
     * Images Optimization Functions *
     *********************************/

    /**
     * Deletes a file or Folder.
     *
     * @param $data
     * @param $folder
     * @param $type
     *
     * @return array
     */
    public static function delete($data, $folder, $type)
    {
        if ($type == 'folder') {
            try {
                $folder = rtrim(self::path.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$data, '/');
                self::deleteFolderRecursive($folder);

                return ['success' => 'Folder '.$data.' deleted successfully'];
            } catch (\Exception $e) {
                return ['error' => 'Error deleting folder'];
            }
        }

        if ($type == 'file') {
            try {
                unlink(self::path.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$data);

                return ['success' => 'File '.$data.' deleted successfully'];
            } catch (\Exception $e) {
                return ['error' => 'Error deleting file'];
            }
        }
    }

    /**
     * Removes a folder recursively.
     *
     * @param $dir
     */
    private static function deleteFolderRecursive($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir.'/'.$object)) {
                        self::deleteFolderRecursive($dir.'/'.$object);
                    } else {
                        unlink($dir.'/'.$object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}
