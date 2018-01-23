<?php

namespace Orchid\Platform\Attachments;

use Mimey\MimeTypes;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Core\Models\Attachment;
use Illuminate\Filesystem\FilesystemAdapter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    /**
     * @var int
     */
    public $time;

    /**
     * @var false|string
     */
    public $date;

    /**
     * @var MimeTypes
     */
    public $mimes;

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var Storage
     */
    public $storage;

    /**
     * @var string
     */
    public $fullPath;

    /**
     * @var
     */
    private $hash;

    /**
     * File constructor.
     *
     * @param UploadedFile      $file
     * @param FilesystemAdapter $storage
     */
    public function __construct(UploadedFile $file, FilesystemAdapter $storage)
    {
        $this->time = time();
        $this->date = date('Y/m/d');
        $this->file = $file;
        $this->mimes = new MimeTypes;
        $this->fullPath = storage_path('app/public/'.DIRECTORY_SEPARATOR.$this->date.DIRECTORY_SEPARATOR);
        $this->loadHashFile();
        $this->storage = $storage;
    }

    /**
     * @return $this
     */
    private function loadHashFile()
    {
        $this->hash = $this->getHashFile();

        return $this;
    }

    /**
     * @return string
     */
    public function getHashFile()
    {
        return sha1_file($this->file->getRealPath());
    }

    /**
     * @return mixed
     */
    public function load()
    {
        $file = $this->getMatchesHash();

        if (is_null($file)) {
            $this->storage->makeDirectory($this->date);

            if (substr($this->file->getMimeType(), 0, 5) == 'image') {
                foreach (config('platform.images', []) as $key => $value) {
                    $this->saveImageProcessing($key, $value['width'], $value['height'], $value['quality']);
                }
            }

            $file = $this->save();

            return $file;
        }

        $file = $file->replicate()->fill([
            'sort'    => 0,
            'user_id' => Auth::id(),
        ]);
        $file->save();

        return $file;
    }

    /**
     * @return mixed
     */
    private function getMatchesHash()
    {
        return Attachment::where('hash', $this->hash)->first();
    }

    /**
     * @return mixed
     */
    private function save()
    {
        $hashName = sha1($this->time.$this->file->getClientOriginalName());
        $name = $hashName.'.'.$this->getClientOriginalExtension();

        $this->storage->putFileAs($this->date, $this->file, $name, [
            'mime_type' => $this->getMimeType(),
        ]);

        return Attachment::create([
            'name'          => $hashName,
            'original_name' => $this->file->getClientOriginalName(),
            'mime'          => $this->getMimeType(),
            'extension'     => $this->getClientOriginalExtension(),
            'size'          => $this->file->getClientSize(),
            'path'          => $this->date.DIRECTORY_SEPARATOR,
            'hash'          => $this->hash,
            'user_id'       => Auth::id(),
        ]);
    }

    /**
     * @return string
     */
    private function getClientOriginalExtension()
    {
        $extension = $this->file->getClientOriginalExtension();
        if (empty($extension)) {
            $extension = $this->mimes->getExtension($this->file->getClientMimeType());
        }

        return $extension;
    }

    /**
     * @return File|string
     */
    public function getMimeType()
    {
        if (! is_null($type = $this->mimes->getMimeType($this->getClientOriginalExtension()))) {
            return $type;
        }

        if (! is_null($type = $this->mimes->getMimeType($this->file->getClientMimeType()))) {
            return $type;
        }

        return 'unknown';
    }

    /**
     * @param null $name
     * @param null $width
     * @param null $height
     * @param int  $quality
     */
    private function saveImageProcessing($name = null, $width = null, $height = null, $quality = 100)
    {
        if (! is_null($name)) {
            $name = '_'.$name;
        }

        $name = sha1($this->time.$this->file->getClientOriginalName()).$name.'.'.$this->getClientOriginalExtension();

        $content = Image::make($this->file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($this->getClientOriginalExtension(), $quality);

        $this->storage->put($this->date.'/'.$name, $content, [
            'mime_type' => $this->getMimeType(),
        ]);
    }
}
