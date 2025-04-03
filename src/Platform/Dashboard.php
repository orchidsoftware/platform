<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Orchid\Support\Attributes\FlushOctaneState;

class Dashboard
{
    use Configuration\ManagesMenu,
        Configuration\ManagesModelOptions,
        Configuration\ManagesPackage,
        Configuration\ManagesPermissions,
        Configuration\ManagesResources,
        Configuration\ManagesScreens,
        Configuration\ManagesSearch,
        Macroable;

    /**
     * Get the route with the dashboard prefix.
     */
    public static function prefix(string $path = ''): string
    {
        $prefix = config('platform.prefix');

        return Str::start($prefix.$path, '/');
    }

    /**
     * Clear all persistent state information in the Orchid.
     *
     * This method is essential for Laravel Octane to properly handle stateful requests
     * when the Dashboard is used as a singleton. It ensures that any stored data
     * and state information are reset, avoiding potential issues with stale or
     * inconsistent data between requests.
     */
    public function flush(): void
    {
        $properties = (new \ReflectionClass($this))->getProperties();

        foreach ($properties as $property) {
            foreach ($property->getAttributes() as $attribute) {
                if ($attribute->getName() !== FlushOctaneState::class) {
                    continue;
                }

                $property->setValue($this, $property->getDefaultValue());
            }
        }
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
        $publishedPath = public_path('vendor/orchid/manifest.json');

        throw_unless(File::exists($publishedPath), new RuntimeException('Orchid assets are not published. Please run: `php artisan orchid:publish`'));

        return File::get($publishedPath) === File::get(__DIR__.'/../../public/manifest.json');
    }

    /**
     * @return \Illuminate\Foundation\Vite
     */
    public static function vite(): \Illuminate\Foundation\Vite
    {
        return Vite::useBuildDirectory('vendor/orchid')
            ->useManifestFilename('manifest.json')
            ->useStyleTagAttributes(['data-turbo-track' => 'reload'])
            ->useScriptTagAttributes(['data-turbo-track' => 'reload'])
            ->withEntryPoints(['resources/js/app.js', 'resources/sass/app.scss'])
            ->createAssetPathsUsing(function (string $path, ?bool $secure) {

                if (\Orchid\Support\Locale::isRtl() && Str::endsWith($path, '.css')) {
                    $path = Str::replaceLast('.css', '.rtl.css', $path);
                }

                return asset($path, $secure);
            });
    }
}
