<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Menu
{
    /**
     * Slug for main menu.
     */
    public const MAIN = 'Main';

    /**
     * Slug for system page.
     */
    public const SYSTEMS = 'Systems';

    /**
     * Slug for dropdown profile.
     */
    public const PROFILE = 'Profile';

    /**
     * The contents of the menu.
     *
     * @var Collection
     */
    public $container;

    /**
     * DashboardMenu constructor.
     */
    public function __construct()
    {
        $this->container = collect();
    }

    /**
     * Adding a new element to the container.
     *
     * @param string   $place
     * @param ItemMenu $itemMenu
     *
     * @return $this
     */
    public function add(string $place, ItemMenu $itemMenu)
    {
        $arg = get_object_vars($itemMenu);

        if (array_key_exists('display', $arg) && ! $arg['display']) {
            return $this;
        }

        $slug = $arg['slug'];

        $this->container[$slug] = [
            'location' => $itemMenu->place ?? $place,
            'arg'      => $arg,
            'sort'     => $arg['sort'],
        ];

        return $this;
    }

    /**
     * Generate on the menu display.
     *
     * @param string $location
     * @param string $template
     *
     * @return string
     */
    public function render(string $location, string $template = 'platform::partials.mainMenu'): string
    {
        $this->checkAccess();

        return $this->findAllChildren($location)
            ->sortBy('sort')
            ->filter(function ($value) {
                if ($value['withChildren'] && $value['hideEmpty']) {
                    return $this->showCountElement($value['slug']);
                }

                return true;
            })
            ->map(static function ($value) use ($template) {
                return view($template, $value)->render();
            })->implode(' ');
    }

    /**
     * @param string $location
     *
     * @return Collection
     */
    public function build(string $location): Collection
    {
        return $this->findAllChildren($location)->filter(static function ($value) {
            return count($value['children']);
        });
    }

    /**
     * @return Collection
     */
    private function checkAccess()
    {
        $user = Auth::guard(config('platform.guard'))->user();

        $this->container = $this->container
            ->filter(static function ($item) use ($user) {
                if (! isset($item['arg']['permission'])) {
                    return true;
                }

                return optional($user)->hasAccess($item['arg']['permission']);
            });

        return $this->container;
    }

    /**
     * @param string $key
     *
     * @return Collection
     */
    private function findAllChildren(string $key): Collection
    {
        return $this->checkAccess()
            ->where('location', $key)
            ->sortBy('sort')
            ->map(function ($item, $key) {
                $item = $item['arg'];

                $children = $this->findAllChildren($key);

                $item['children'] = $children;

                $children->each(static function ($children) use (&$item) {
                    $item['active'] = array_merge($item['active'], $children['active']);
                });

                return $item;
            });
    }

    /**
     * Checks whether there are child elements.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function showCountElement(string $slug): bool
    {
        return $this->container->where('location', $slug)->isNotEmpty();
    }
}
