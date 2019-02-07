<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
     * Serve the requested resource.
     *
     * @param string $package
     * @param string $path
     *
     * @param Dashboard $dashboard
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(string $package, string $path, Dashboard $dashboard)
    {
        $dir = $dashboard
            ->getPublicDirectory()
            ->get($package);

        abort_if(is_null($dir), 404);

        foreach ((new Finder)->ignoreUnreadableDirs()->in($dir)->files()->path($path)->name(basename($path)) as $resource) {
            $this->resource = $resource;
        }

        abort_if(is_null($this->resource), 404);

        $mime = new MimeTypes();
        $mime = $mime->getMimeType($this->resource->getExtension());

        return response(
            $this->resource->getContents(),
            200,
            [
                'Content-Type' => $mime ?? 'text/plain',
                'Cache-Control' => 'public, max-age=31536000',
            ]
        );
    }
}
