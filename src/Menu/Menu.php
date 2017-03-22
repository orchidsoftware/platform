<?php

namespace Orchid\Menu;

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
     * Views display.
     *
     * @var
     */
    private $template;

    /**
     * Arguments menu form
     *  * For the transfer of Views.
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
    public function place(string $location): Menu
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param $template
     *
     * @return Menu
     */
    public function template(string $template): Menu
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
    public function sortBy(int $sort): Menu
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Adding a new element to the container.
     *
     * @param string $place
     * @param string $template
     * @param        $arg
     * @param int    $sort
     */
    public function add(string $place, string $template, array $arg, int $sort = 500)
    {
        $this->location = $place;
        $this->template = $template;
        $this->arg = $arg;
        $this->sort = $sort;

        $this->item = [
            'location' => $this->location,
            'template' => $this->template,
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
    public function render(string $location, string $template = null): string
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
