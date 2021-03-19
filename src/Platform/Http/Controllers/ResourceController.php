<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Orchid\Attachment\MimeTypes;
use Orchid\Platform\Dashboard;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller
{
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

        /* Changing the separator for Windows operating systems */
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

        $resource = collect($iterator)
            ->filter(static function (SplFileInfo $file) use ($path) {
                return $file->getRelativePathname() === $path;
            })
            ->first();

        abort_if($resource === null, 404);

        $mime = $this->mimeTypes->getMimeType($resource->getExtension());

        return response()->file($resource->getRealPath(), [
            'Content-Type'  => $mime ?? 'text/plain',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
