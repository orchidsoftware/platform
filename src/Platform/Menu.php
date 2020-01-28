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
     * Position menu.
     *
     * @var string
     */
    private $location;

    /**
     * Arguments menu form
     * For the transfer of Views.
     *
     * @var array|null
     */
    private $arg;

    /**
     * Sort menu item.
     *
     * @var int
     */
    private $sort;

    /**
     * Synthesis element.
     *
     * @var array
     */
    private $item;

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

        $this->location = $place;
        $this->arg = $arg;
        $this->sort = $arg['sort'];

        $this->item = [
            'location' => $this->location,
            'arg'      => $this->arg,
            'sort'     => $this->sort,
        ];

        $this->container[$this->arg['slug']] = $this->item;

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
                if (! $value['childs']) {
                    return true;
                }

                return $this->showCountElement($value['slug']);
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
        $user = Auth::user();

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
        return $this->container->where('location', $slug)->count() > 0;
    }
}
