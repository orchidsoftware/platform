<?php

declare(strict_types=1);

namespace Orchid\Attachment;

use Illuminate\Support\Arr;
use Symfony\Component\Mime\MimeTypes as Mime;

class MimeTypes
{
    /**
     * The instance of Symfony's MimeTypes class.
     *
     * @var MimeTypes Holds the instance of MimeTypes Symfony's class
     */
    protected $mime;

    /**
     * Create a new MimeTypes instance.
     */
    public function __construct()
    {
        $this->mime = new Mime;
    }

    /**
     * Get the file extension associated with a given MIME type.
     *
     * @param string     $mimeType The MIME type to look up.
     * @param mixed|null $default  The default value to return if no extension is found.
     *
     * @return string|null The file extension, or the default value if no extension is found.
     */
    public function getExtension(string $mimeType, ?string $default = null): ?string
    {
        return Arr::first($this->mime->getExtensions($mimeType), null, $default);
    }

    /**
     * Get the MIME type associated with a given file extension.
     *
     * @param string     $ext     The file extension to look up.
     * @param mixed|null $default The default value to return if no MIME type is found.
     *
     * @return string|null The MIME type, or the default value if no MIME type is found.
     */
    public function getMimeType(string $ext, ?string $default = null): ?string
    {
        return Arr::first($this->mime->getMimeTypes($ext), null, $default);
    }
}
