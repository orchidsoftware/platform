<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Screen;
use RuntimeException;

class Dashboard
{
    use Macroable;

    /**
     * The current Orchid version.
     *
     * @deprecated Use `Dashboard::version()` instead.
     */
    public const VERSION = '14.35.1';

    /**
     * @deprecated
     *
     * Slug for main menu.
     */
    public const MENU_MAIN = 'Main';

    /**
     * The Dashboard configuration options.
     *
     * @var array
     */
    protected static $options = [
        'search' => [],
        'models' => [],
    ];

    /**
     * The collection of menu items.
     *
     * @var Collection<Menu>
     */
    public $menu;

    /**
     * Collection of JS and CSS resources for the panel.
     *
     * @var Collection
     */
    public $resources;

    /**
     * Collection of permissions for the application.
     *
     * @var Collection
     */
    private $permission;

    /**
     * The current screen instance.
     *
     * @var Screen|null
     */
    private $currentScreen;

    /**
     * Determines whether the current request is a partial request or not.
     * A partial request is a request that only loads a specific part of the page, such as a modal window or a section of content,
     * instead of loading the entire page.
     *
     * @var bool Set to true if the current request is a partial request, false otherwise.
     */
    private bool $partialRequest = false;

    /**
     * Dashboard constructor.
     */
    public function __construct()
    {
        $this->resources = collect();

        $this->permission = collect([
            'all'     => collect(),
            'removed' => collect(),
        ]);

        $this->flushState();
    }

    /**
     * Get the version number of the application.
     */
    public static function version(): string
    {
        return static::VERSION;
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

    /**
     * Get the route with the dashboard prefix.
     */
    public static function prefix(string $path = ''): string
    {
        $prefix = config('platform.prefix');

        return Str::start($prefix.$path, '/');
    }

    /**
     * Configure the Dashboard application.
     */
    public static function configure(array $options): void
    {
        static::$options = $options;
    }

    /**
     * Get a Dashboard configuration option.
     *
     * @param mixed|null $default
     *
     * @return mixed
     */
    public static function option(string $key, $default = null)
    {
        return Arr::get(static::$options, $key, $default);
    }

    /**
     * Get the model instance for a given key or class name.
     *
     * @return mixed
     */
    public static function modelClass(string $key, ?string $default = null)
    {
        $model = static::model($key, $default);

        return class_exists($model) ? new $model : $model;
    }

    /**
     * Get the class name for a given Dashboard model.
     */
    public static function model(string $key, ?string $default = null): string
    {
        return Arr::get(static::$options, 'models.'.$key, $default ?? $key);
    }

    /**
     * Get the user model class name.
     */
    public static function useModel(string $key, string $custom): void
    {
        static::$options['models'][$key] = $custom;
    }

    /**
     * The real path to the package files.
     */
    public static function path(string $path = ''): string
    {
        $current = dirname(__DIR__, 2);

        return realpath($current.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * Registers a ItemPermission that defines authentication permissions.
     *
     * @return $this
     */
    public function registerPermissions(ItemPermission $permission): self
    {
        if (empty($permission->group)) {
            return $this;
        }

        $old = $this->permission->get('all')
            ->get($permission->group, []);

        $this->permission->get('all')
            ->put($permission->group, array_merge_recursive($old, $permission->items));

        return $this;
    }

    /**
     * Registers a set of models for which full-text search is required.
     *
     * @return $this
     */
    public function registerSearch(array $models): self
    {
        static::$options['search'] = array_merge($models, static::$options['search'] ?? []);

        return $this;
    }

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
     * Get the list of searchable models, ensuring uniqueness and resolving model instances.
     *
     * @return Collection The collection of searchable models.
     */
    public function getSearch(): Collection
    {
        return collect(static::$options['search'])
            ->unique()
            ->transform(static fn ($model) => is_object($model) ? $model : resolve($model));
    }

    /**
     * Retrieve permissions based on specified groups.
     *
     * @param array|string $groups
     */
    public function getPermission($groups = []): Collection
    {
        $all = $this->permission->get('all')
            ->when(! empty($groups), fn (Collection $collection) => $collection->only($groups));

        $removed = $this->permission->get('removed');

        if (! $removed->count()) {
            return $all;
        }

        return $all->map(static function ($group) use ($removed) {
            foreach ($group[key($group)] as $key => $item) {
                if ($removed->contains($item)) {
                    unset($group[key($group)]);
                }
            }

            return $group;
        });
    }

    /**
     * Get all registered permissions with the enabled state.
     *
     * @param array|string $groups
     */
    public function getAllowAllPermission($groups = []): Collection
    {
        return $this->getPermission($groups)
            ->collapse()
            ->reduce(static fn (Collection $permissions, array $item) => $permissions->put($item['slug'], true), collect());
    }

    /**
     * Remove a specific permission by key.
     *
     * @return $this
     */
    public function removePermission(string $key): self
    {
        $this->permission->get('removed')->push($key);

        return $this;
    }

    /**
     * Get the current screen instance.
     *
     * @return $this
     */
    public function setCurrentScreen(Screen $screen, bool $partialRequest = false): self
    {
        $this->currentScreen = $screen;
        $this->partialRequest = $partialRequest;

        App::singleton($screen::class, static fn () => $screen);
        App::rebinding($screen::class, static fn () => app($screen::class));

        return $this;
    }

    /**
     * Get the current screen instance.
     *
     * @return Screen|null The current screen instance or null if not set.
     */
    public function getCurrentScreen(): ?Screen
    {
        return $this->currentScreen;
    }

    /**
     * Determines whether the current request is a partial request or not.
     *
     * A partial request is a request that only loads a specific part of the page, such as a modal window or a section of content,
     * instead of loading the entire page. This method returns a boolean value indicating whether the current request is a partial
     * request or not, based on the value of the $partialRequest property.
     *
     * @return bool True if the current request is a partial request, false otherwise.
     */
    public function isPartialRequest(): bool
    {
        return $this->partialRequest;
    }

    /**
     * Register a menu element with the Dashboard.
     *
     * @param Menu $menu The menu element to add.
     *
     * @return $this
     */
    public function registerMenuElement(Menu $menu): Dashboard
    {
        if ($menu->get('sort', 0) === 0) {
            $menu->sort($this->menu->count() + 1);
        }

        $this->menu->add($menu);

        return $this;
    }

    /**
     * Render the menu as a string for display.
     *
     * @throws \Throwable If rendering fails.
     *
     * @return string The rendered menu HTML.
     */
    public function renderMenu(): string
    {
        return $this->menu
            ->sort(fn (Menu $current, Menu $next) => $current->get('sort', 0) <=> $next->get('sort', 0))
            ->map(fn (Menu $menu) => (string) $menu->render())
            ->implode('');
    }

    /**
     * Check if the menu is empty.
     *
     * @return bool True if the menu is empty, otherwise false.
     */
    public function isEmptyMenu(): bool
    {
        return $this->menu->isEmpty();
    }

    /**
     * Add submenu items to a menu element identified by its slug.
     *
     * @param string $slug The slug of the menu element to update.
     * @param Menu[] $list Array of submenu items to add.
     *
     * @return $this
     */
    public function addMenuSubElements(string $slug, array $list): Dashboard
    {
        $this->menu = $this->menu
            ->map(fn (Menu $menu) => $slug === $menu->get('slug')
                ? $menu->list($list)
                : $menu);

        return $this;
    }

    /**
     * Clear all persistent state information in the Dashboard.
     *
     * This method is essential for Laravel Octane to properly handle stateful requests
     * when the Dashboard is used as a singleton. It ensures that any stored data
     * and state information are reset, avoiding potential issues with stale or
     * inconsistent data between requests.
     */
    public function flushState(): void
    {
        $this->menu = collect();

        $this->currentScreen = null;
        $this->partialRequest = false;
    }
}
