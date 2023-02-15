<?php

declare(strict_types=1);

namespace Orchid\Attachment\Contracts;

use Illuminate\Http\UploadedFile;

interface Engine
{
    /**
     * Engine constructor.
     */
    public function __construct(UploadedFile $file);

    /**
     * Returns name to create a real file on disk and write to the database.
     * Specified any string without extension.
     * Please note that some characters are prohibited on different operating systems.
     *
     * For example "calc"
     */
    public function name(): string;

    /**
     * Returns name to create a file with extension.
     *
     * For example "calc.exe"
     */
    public function fullName(): string;

    /**
     * Returns the relative file path.
     */
    public function path(): string;

    /**
     * Returns file hash string that will indicate
     * that the same file has already been downloaded.
     */
    public function hash(): string;

    /**
     * Return a Unix file upload timestamp.
     */
    public function time(): int;

    /**
     * Returns file extension.
     *
     * For example `jpg`
     */
    public function extension(): string;

    /**
     * Returns the file mime type.
     */
    public function mime(): string;
}
