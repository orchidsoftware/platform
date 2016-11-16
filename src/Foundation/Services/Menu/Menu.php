<?php

namespace Orchid\Foundation\Services\Menu;

class Menu
{
    /**
     *  Position menu.
     *
     * @var
     */
    private $location;

    /**
     * The contents of the menu.
     *
     * @var
     */
    public $container;

    /**
     * Views display.
     *
     * @var
     */
    private $template;

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
     * @return $this
     */
    public function place($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param $template
     *
     * @return $this
     */
    public function template($template)
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
     * @return $this
     */
    public function sortBy($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Adding a new element to the container.
     *
     * @param null $place
     * @param null $template
     * @param null $arg
     * @param int  $sort
     */
    public function add($place = null, $template = null, $arg = null, $sort = 500)
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
     * @param $location
     * @param null $template
     *
     * @return string
     */
    public function render($location, $template = null)
    {
        $html = '';
        foreach ($this->container->where('location', $location)->sortBy('sort') as $key => $value) {
            if (! is_null($template)) {
                $value['template'] = $template;
            }

            $html .= view($value['template'],
                collect($value['arg'])
            );
        }

        return $html;
    }
}
