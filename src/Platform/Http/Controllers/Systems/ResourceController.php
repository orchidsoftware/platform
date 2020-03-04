<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class ResourceController.
 */
class ResourceController
{
    /**
     * @var SplFileInfo|null
     */
    private $resource;

    /**
     * @var MimeTypes
     */
    private $mimeTypes;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * ResourceController constructor.
     *
     * @param MimeTypes $mimeTypes
     * @param Finder    $finder
     */
    public function __construct(MimeTypes $mimeTypes, Finder $finder)
    {
        $this->mimeTypes = $mimeTypes;
        $this->finder = $finder;
    }

    /**
     * Serve the requested resource.
     *
     * @param string    $package
     * @param string    $path
     * @param Dashboard $dashboard
     *
     * @return BinaryFileResponse
     */
    public function show(string $package, string $path, Dashboard $dashboard)
    {
        $dir = $dashboard
            ->getPublicDirectory()
            ->get($package);

        abort_if($dir === null, 404);

        $resources = $this->finder
            ->ignoreUnreadableDirs()
            ->followLinks()
            ->in($dir)
            ->files()
            ->path(dirname($path))
            ->name(basename($path));

        $iterator = tap($resources->getIterator())->rewind();

        $path = DIRECTORY_SEPARATOR === '\\' ? str_replace('/', DIRECTORY_SEPARATOR, $path) : $path;

        $this->resource = collect($iterator)
            ->filter(static function (SplFileInfo $file) use ($path) {
                return $file->getRelativePathname() === $path;
            })
            ->first();

        abort_if($this->resource === null, 404);

        $mime = $this->mimeTypes->getMimeType($this->resource->getExtension());

        return response()->file($this->resource->getRealPath(), [
            'Content-Type'  => $mime ?? 'text/plain',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
