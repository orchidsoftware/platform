<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

trait ManagesResources
{
    /**
     * Collection of JS and CSS resources for the panel.
     *
     * @var Collection
     */
    public $resources;

    /**
     * Register a resource with the given key.
     *
     * @param string|array $value
     */
    public function registerResource(string $key, $value): self
    {
        $item = $this->resources->get($key, []);

        $this->resources[$key] = array_merge($item, Arr::wrap($value));

        return $this;
    }

    /**
     * Return CSS\JS.
     *
     * @param null $key
     *
     * @return array|Collection|mixed
     */
    public function getResource($key = null)
    {
        if ($key === null) {
            return $this->resources;
        }

        return $this->resources->get($key);
    }

    /**
     * Determine published assets are up-to-date.
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    public static function assetsAreCurrent(): bool
    {
        $publishedPath = public_path('vendor/orchid/mix-manifest.json');

        throw_unless(File::exists($publishedPath), new RuntimeException('Orchid assets are not published. Please run: `php artisan orchid:publish`'));

        return File::get($publishedPath) === File::get(__DIR__.'/../../public/mix-manifest.json');
    }
}
