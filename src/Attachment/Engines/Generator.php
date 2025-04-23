<?php

declare(strict_types=1);

namespace Orchid\Attachment\Engines;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Orchid\Attachment\Contracts\Engine;
use Orchid\Attachment\MimeTypes;
use RuntimeException;

class Generator implements Engine
{
    protected const UNKNOWN = 'unknown';

    /**
     * The uploaded file instance.
     *
     * @var UploadedFile
     */
    protected UploadedFile $file;

    /**
     * The Unix timestamp indicating the time when the file was created
     *
     * @var int
     */
    protected int $time;

    /**
     * The generated unique identifier
     *
     * @var string
     */
    protected string $uniqueId;

    /**
     * The mime types instance.
     *
     * @var MimeTypes
     */
    protected MimeTypes $mimes;

    /**
     * The file path.
     *
     * @var ?string
     */
    protected ?string $path;

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
        return hash(
            $this->hashAlgorithm(),
            $this->uniqueId.$this->file->getClientOriginalName()
        );
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
     * @param string|null $path
     *
     * @return static
     */
    public function setPath(?string $path = null): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the file hash that indicates that the same file has already been downloaded.
     */
    public function hash(): string
    {
        $hash = hash_file(
            $this->hashAlgorithm(),
            $this->file->path()
        );

        if ($hash === false) {
            throw new RuntimeException(sprintf(
                'Failed to generate a hash for the file: %s.',
                $this->file->path()
            ));
        }

        return $hash;
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
     *
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function extension(): string
    {
        $extension = $this->file->getClientOriginalExtension();

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType(), static::UNKNOWN)
            : $extension;
    }

    /**
     * Get the file mime type.
     */
    public function mime(): string
    {
        return $this->mimes->getMimeType($this->extension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? static::UNKNOWN;
    }

    /**
     * Get the hashing algorithm used for file name and content hashing.
     *
     * This method centralizes the choice of hash algorithm used throughout
     * the Generator. Changing the return value here will affect both
     * the generated file name and the file content hash.
     *
     * Supported algorithms include those listed by `hash_algos()`,
     * such as 'sha1', 'sha256', 'md5', etc.
     *
     * @see https://www.php.net/manual/en/function.hash.php
     * @see https://www.php.net/manual/en/function.hash-file.php
     *
     * @return string The name of the hashing algorithm to use.
     */
    protected function hashAlgorithm(): string
    {
        return 'sha1';
    }
}
