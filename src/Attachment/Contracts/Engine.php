<?php

declare(strict_types=1);

namespace Orchid\Attachment\Contracts;

use Illuminate\Http\UploadedFile;

interface Engine
{
    /**
     * Create a new instance of the engine.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file);

    /**
     * Get the name of the file without extension.
     * Some characters are prohibited on different operating systems.
     *
     * For example, "calc"
     *
     * @return string
     */
    public function name(): string;

    /**
     * Get the name of the file with extension.
     *
     * For example, "calc.exe"
     */
    public function fullName(): string;

    /**
     * Get the relative file path.
     */
    public function path(): string;

    /**
     * Get the file hash string that will indicate
     * if the same file has already been downloaded.
     */
    public function hash(): string;

    /**
     * Get the Unix timestamp of file upload.
     */
    public function time(): int;

    /**
     * Get the file extension.
     *
     * For example, `jpg`
     */
    public function extension(): string;

    /**
     * Get the file mime type.
     */
    public function mime(): string;
}
