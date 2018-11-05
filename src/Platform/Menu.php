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
     * @var
     */
    private $template;

    /**
     * DashboardMenu constructor.
     */
    public function __construct()
    {
        $this->container = collect();
    }

    /**
     * Setting the menu position.
     *
     * @param $location
     *
     * @return Menu
     */
    public function place(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param $template
     *
     * @return Menu
     */
    public function template(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param $arg
     *
     * @return $this
     */
    public function with($arg)
    {
        $this->arg = $arg;

        return $this;
    }

    /**
     * @param $sort
     *
     * @return Menu
     */
    public function sortBy(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Adding a new element to the container.
     *
     * @param string $place
     * @param array|ItemMenu $arg
     *
     * @return $this
     */
    public function add(string $place, $arg)
    {
        if ($arg instanceof ItemMenu) {
            $arg = get_object_vars($arg);
        }

        if (array_key_exists('show', $arg) && !$arg['show']) {
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
            'arg' => $this->arg,
            'sort' => $this->sort,
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
        $html = '';

        /*
         * Check access
         */
        if (!isset($this->user)) {
            $this->user = Auth::user();
            $user = $this->user;

            $this->container = $this->container->filter(function ($item) use ($user) {
                return isset($item['arg']['permission']) ? optional($user)->hasAccess($item['arg']['permission']) : true;
            });
        }

        foreach ($this->container->where('location', $location)->sortBy('sort') as $key => $value) {
            if (!array_key_exists('template', $value)) {
                $value['template'] = 'platform::partials.mainMenu';
            }

            if (!is_null($template)) {
                $value['template'] = $template;
            }

            $html .= view($value['template'], collect($value['arg']));
        }

        return $html;
    }

    /**
     * @param string $location
     *
     * @return Collection
     */
    public function build(string $location): Collection
    {
        /*
         * Check access
         */
        if (!isset($this->user)) {
            $this->user = Auth::user();
            $user = $this->user;

            $this->container = $this->container->filter(function ($item) use ($user) {
                return isset($item['arg']['permission']) ? $user->hasAccess($item['arg']['permission']) : true;
            });
        }

        return $this->findAllChildren($location)->filter(function ($value) {
            return count($value['children']);
        });
    }

    /**
     * @param string $key
     *
     * @return Collection
     */
    private function findAllChildren($key): Collection
    {
        return $this->container
            ->where('location', $key)
            ->sortBy('sort')
            ->map(function ($item, $key) {
                $item = $item['arg'];
                $item['children'] = $this->findAllChildren($key);

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
