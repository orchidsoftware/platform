<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mimey\MimeTypes;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\UploadFileEvent;

/**
 * Class File.
 */
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
     * @var Filesystem
     */
    public $storage;

    /**
     * @var string
     */
    public $fullPath;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    public $disk;

    /**
     * @var string|null
     */
    public $group;

    /**
     * File constructor.
     *
     * @param UploadedFile $file
     * @param string       $disk
     * @param string       $group
     */
    public function __construct(UploadedFile $file, string $disk = 'public', string $group = null)
    {
        abort_if($file->getSize() === false, 415, 'File failed to load.');

        $this->time = time();
        $this->date = date('Y/m/d', $this->time);
        $this->file = $file;
        $this->mimes = new MimeTypes();
        $this->fullPath = storage_path("app/public/$this->date/");
        $this->disk = $disk;
        $this->group = $group;
        $this->storage = Storage::disk($disk);
        $this->loadHashFile();
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
    public function getHashFile(): string
    {
        return sha1_file($this->file->getRealPath());
    }

    /**
     * @return Model|Attachment
     */
    public function load(): Model
    {
        $file = $this->getMatchesHash();

        if (! $this->storage->has($this->date)) {
            $this->storage->makeDirectory($this->date);
        }

        if (is_null($file)) {
            return $this->save();
        }

        $file = $file->replicate()->fill([
            'original_name' => $this->file->getClientOriginalName(),
            'sort'          => 0,
            'user_id'       => Auth::id(),
            'group'         => $this->group,
        ]);

        $file->save();

        return $file;
    }

    /**
     * @return mixed
     */
    private function getMatchesHash()
    {
        return Dashboard::model(Attachment::class)::where('hash', $this->hash)->where('disk', $this->disk)->first();
    }

    /**
     * @return Model|Attachment
     */
    private function save(): Model
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
            'size'          => $this->file->getSize(),
            'path'          => $this->date . '/',
            'hash'          => $this->hash,
            'disk'          => $this->disk,
            'group'         => $this->group,
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

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType())
            : $extension;
    }

    /**
     * @return File|string
     */
    public function getMimeType()
    {
        return $this->mimes->getMimeType($this->getClientOriginalExtension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? 'unknown';
    }
}
