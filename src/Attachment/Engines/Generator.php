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
     * The uploaded file instance.
     *
     * @var UploadedFile
     */
    protected $file;

    /**
     * The Unix timestamp indicating the time when the file was created
     *
     * @var int
     */
    protected $time;

    /**
     * The generated unique identifier
     *
     * @var string
     */
    protected $uniqueId;

    /**
     * The mime types instance.
     *
     * @var MimeTypes
     */
    protected $mimes;

    /**
     * The file path.
     *
     * @var ?string
     */
    protected $path;

    /**
     * Create a new Generator instance.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return void
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->path = null;
        $this->time = time();
        $this->mimes = new MimeTypes;
        $this->uniqueId = uniqid('', true);
    }

    /**
     * Get the file name to create a real file on disk and write to the database.
     * Use any string without an extension.
     */
    public function name(): string
    {
        return sha1($this->uniqueId.$this->file->getClientOriginalName());
    }

    /**
     * Get the file name to create a file with extension.
     */
    public function fullName(): string
    {
        return Str::finish($this->name(), '.').$this->extension();
    }

    /**
     * Get the relative file path.
     */
    public function path(): string
    {
        return $this->path ?? date('Y/m/d', $this->time());
    }

    /**
     * Set the custom file path.
     *
     * @return Generator
     */
    public function setPath(?string $path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the file hash that indicates that the same file has already been downloaded.
     */
    public function hash(): string
    {
        return sha1_file($this->file->path());
    }

    /**
     * Get the Unix file upload timestamp.
     */
    public function time(): int
    {
        return $this->time;
    }

    /**
     * Get the file extension.
     */
    public function extension(): string
    {
        $extension = $this->file->getClientOriginalExtension();

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType(), 'unknown')
            : $extension;
    }

    /**
     * Get the file mime type.
     */
    public function mime(): string
    {
        return $this->mimes->getMimeType($this->extension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? 'unknown';
    }
}
