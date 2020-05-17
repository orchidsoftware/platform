<?php

declare(strict_types=1);

namespace Orchid\Attachment\Contracts;

use Illuminate\Http\UploadedFile;

interface Engine
{
    /**
     * Engine constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file);

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function fullName(): string;

    /**
     * @return string
     */
    public function path(): string;

    /**
     * @return string
     */
    public function hash(): string;

    /**
     * @return int
     */
    public function time(): int;

    /**
     * @return string
     */
    public function mime(): string;

    /**
     * @return string
     */
    public function getClientOriginalExtension(): string;
}
