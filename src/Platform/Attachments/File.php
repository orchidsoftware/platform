<?php

declare(strict_types=1);

namespace Orchid\Platform\Attachments;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Orchid\Platform\Events\UploadFileEvent;
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
     * @var string
     */
    public $disk;

    /**
     * File constructor.
     *
     * @param UploadedFile $file
     * @param string       $disk
     */
    public function __construct(UploadedFile $file, string $disk)
    {
        $this->time = time();
        $this->date = date('Y/m/d', $this->time);
        $this->file = $file;
        $this->mimes = new MimeTypes();
        $this->fullPath = storage_path("app/public/$this->date/");
        $this->loadHashFile();
        $this->disk = $disk;
        $this->storage = Storage::disk($disk);
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

            return $this->save();
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
        return Dashboard::model(Attachment::class)::where('hash', $this->hash)->first();
    }

    /**
     * @return mixed
     */
    private function save() : Attachment
    {
        $hashName = sha1($this->time.$this->file->getClientOriginalName());
        $name = $hashName.'.'.$this->getClientOriginalExtension();

        $this->storage->putFileAs($this->date, $this->file, $name, [
            'mime_type' => $this->getMimeType(),
        ]);

        $attach = Dashboard::model(Attachment::class)::create([
            'name'          => $hashName,
            'original_name' => $this->file->getClientOriginalName(),
            'mime'          => $this->getMimeType(),
            'extension'     => $this->getClientOriginalExtension(),
            'size'          => $this->file->getClientSize(),
            'path'          => $this->date.DIRECTORY_SEPARATOR,
            'hash'          => $this->hash,
            'disk'          => $this->disk,
            'user_id'       => Auth::id(),
        ]);

        event(new UploadFileEvent($attach, $this->time));

        return $attach;
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
}
