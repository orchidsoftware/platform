<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Support\Arr;
use Symfony\Component\Mime\MimeTypes as Mime;

class MimeTypes
{
    /**
     * @var Mime
     */
    protected $mime;

    /**
     * MimeTypes constructor.
     */
    public function __construct()
    {
        $this->mime = new Mime();
    }

    /**
     * @param string     $mimeType
     * @param mixed|null $default
     *
     * @return string|null
     */
    public function getExtension(string $mimeType, string $default = null): ?string
    {
        return Arr::first($this->mime->getExtensions($mimeType), null, $default);
    }

    /**
     * @param string      $ext
     * @param string|null $default
     *
     * @return string|null
     */
    public function getMimeType(string $ext, string $default = null): ?string
    {
        return Arr::first($this->mime->getMimeTypes($ext), null, $default);
    }
}
