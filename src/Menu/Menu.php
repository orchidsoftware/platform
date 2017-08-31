<?php

namespace Orchid\Platform\Menu;

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
     * Setting the menu position.
     *
     * @param $location
     *
     * @return Menu
     */
    public function place(string $location) : Menu
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param $template
     *
     * @return Menu
     */
    public function template(string $template) : Menu
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
    public function sortBy(int $sort) : Menu
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Adding a new element to the container.
     *
     * @param string $place
     * @param        $arg
     */
    public function add(string $place, array $arg)
    {
        $arg = array_merge([
            'icon'    => 'fa fa-file-o',
            'childs'  => false,
            'divider' => false,
            'sort'    => 0,
        ], $arg);

        $this->location = $place;
        $this->arg = $arg;
        $this->sort = $arg['sort'];

        $this->item = [
            'location' => $this->location,
            'arg'      => $this->arg,
            'sort'     => $this->sort,
        ];

        $this->container->push($this->item);
    }

    /**
     * Generate on the menu display.
     *
     * @param string      $location
     * @param string|null $template
     *
     * @return string
     */
    public function render(string $location, string $template = null) : string
    {
        $html = '';

        if (!isset($this->user)) {
            $this->user = Auth::user();
            $user = $this->user;
            $this->container = $this->container->filter(function ($item) use ($user) {
                return (isset($item['arg']['permission'])) ? $user->hasAccess($item['arg']['permission']) : true;
            });
        }

        foreach ($this->container->where('location', $location)->sortBy('sort') as $key => $value) {
            if (!array_key_exists('template', $value)) {
                $value['template'] = 'dashboard::partials.leftMainMenu';
            }

            if (!is_null($template)) {
                $value['template'] = $template;
            }

            $html .= view($value['template'],
                collect($value['arg'])
            );
        }

        return $html;
    }
}
