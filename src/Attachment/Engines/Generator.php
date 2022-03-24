<?php

declare(strict_types=1);

namespace Orchid\Attachment\Engines;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Orchid\Attachment\Contracts\Engine;
use Orchid\Attachment\MimeTypes;

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
     * @var string
     */
    protected $uniqueId;

    /**
     * @var ?string
     */
    protected $path;

    /**
     * Generator constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->path = null;
        $this->time = time();
        $this->mimes = new MimeTypes();
        $this->uniqueId = uniqid('', true);
    }

    /**
     * Returns name to create a real file on disk and write to the database.
     * Specified any string without extension.
     *
     * @return string
     */
    public function name(): string
    {
        return sha1($this->uniqueId.$this->file->getClientOriginalName());
    }

    /**
     * Returns name to create a file with extension.
     *
     * @return string
     */
    public function fullName(): string
    {
        return Str::finish($this->name(), '.').$this->extension();
    }

    /**
     * Returns the relative file path.
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path ?? date('Y/m/d', $this->time());
    }
    
    /**
     * Set a custom path
     *
     * @return Generator
     */
    public function setPath(?string $path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Returns file hash string that will indicate
     * that the same file has already been downloaded.
     *
     * @return string
     */
    public function hash(): string
    {
        return sha1_file($this->file->path());
    }

    /**
     * Return a Unix file upload timestamp.
     *
     * @return int
     */
    public function time(): int
    {
        return $this->time;
    }

    /**
     * Returns file extension.
     *
     * @return string
     */
    public function extension(): string
    {
        $extension = $this->file->getClientOriginalExtension();

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType(), 'unknown')
            : $extension;
    }

    /**
     * Returns the file mime type.
     *
     * @return string
     */
    public function mime(): string
    {
        return $this->mimes->getMimeType($this->extension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? 'unknown';
    }
}
