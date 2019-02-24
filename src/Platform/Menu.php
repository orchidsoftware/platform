<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Menu
{
    /**
     * The contents of the menu.
     *
     * @var
     */
    public $container;

    /**
     *  Position menu.
     *
     * @var
     */
    private $location;

    /**
     * Arguments menu form
     * For the transfer of Views.
     *
     * @var
     */
    private $arg;

    /**
     * Sort menu item.
     *
     * @var
     */
    private $sort;

    /**
     * Synthesis element.
     *
     * @var
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
     * @param string $place
     * @param ItemMenu $arg
     *
     * @return $this
     */
    public function add(string $place, ItemMenu $arg)
    {
        $arg = get_object_vars($arg);

        if (array_key_exists('show', $arg) && ! $arg['show']) {
            return $this;
        }

        $arg = array_merge([
            'icon' => 'icon-folder',
            'sort' => 0,
        ], $arg);

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
     * @param string|null $template
     *
     * @return string
     */
    public function render(string $location, string $template = null): string
    {
        $this->checkAccess();

        $html = '';

        $this->findAllChildren($location)
            ->sortBy('sort')
            ->each(function ($value) use ($template, &$html) {
                if (! array_key_exists('template', $value)) {
                    $value['template'] = 'platform::partials.mainMenu';
                }

                if (! is_null($template)) {
                    $value['template'] = $template;
                }

                $html .= view($value['template'], $value);
            });

        return $html;
    }

    /**
     * @param string $location
     *
     * @return Collection
     */
    public function build(string $location): Collection
    {
        return $this->findAllChildren($location)->filter(function ($value) {
            return count($value['children']);
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function checkAccess()
    {
        $user = Auth::user();

        $this->container = $this->container
            ->filter(function ($item) use ($user) {
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
    private function findAllChildren($key): Collection
    {
        return $this->checkAccess()
            ->where('location', $key)
            ->sortBy('sort')
            ->map(function ($item, $key) {
                $item = $item['arg'];

                $childrens = $this->findAllChildren($key);

                $item['children'] = $childrens;

                $childrens->each(function ($children) use (&$item) {
                    $item['active'] += $children['active'];
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
