<?php

declare(strict_types=1);

namespace Orchid\Attachment\Engines;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Mimey\MimeTypes;
use Orchid\Attachment\Contracts\Engine;

class Generator implements Engine
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var MimeTypes
     */
    protected $mimes;

    /**
     * Generator constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->time = time();
        $this->mimes = new MimeTypes();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return sha1($this->time . $this->file->getClientOriginalName());
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return Str::finish($this->name(), '.') . $this->getClientOriginalExtension();
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return date('Y/m/d', $this->time());
    }

    /**
     * @return string
     */
    public function hash(): string
    {
        return sha1_file($this->file->path());
    }

    /**
     * @return int
     */
    public function time(): int
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getClientOriginalExtension(): string
    {
        $extension = $this->file->getClientOriginalExtension();

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType())
            : $extension;
    }

    /**
     * @return string
     */
    public function mime(): string
    {
        return $this->mimes->getMimeType($this->getClientOriginalExtension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? 'unknown';
    }
}
