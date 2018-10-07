<?php

declare(strict_types=1);

namespace Orchid\Platform;

class ItemMenu
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $route;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $groupname;

    /**
     * @var boolean
     */
    public $divider;

    /**
     * @var boolean
     */
    public $childs;

    /**
     * @var int
     */
    public $sort = 1000;

    /**
     * @var array
     */
    public $badge;

    /**
     * @var bool
     */
    public $show = true;

    /**
     * @var string
     */
    public $active;

    /**
     * @var string
     */
    public $permission;

    /**
     * @param string $permission
     *
     * @return ItemMenu
     */
    public function setPermission(string $permission): ItemMenu
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @param string $active
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function setActive(string $active): ItemMenu
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param $label
     *
     * @return \Orchid\Platform\ItemMenu
     */
    static function setLabel(string $label): ItemMenu
    {
        $item = new self();

        $item->label = $label;
        $item->slug = str_slug($label);

        return $item;
    }

    /**
     * @param string $icon
     *
     * @return ItemMenu
     */
    public function setIcon(string $icon): ItemMenu
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param bool $show
     *
     * @return ItemMenu
     */
    public function setShow(bool $show): ItemMenu
    {
        $this->show = $show;

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return ItemMenu
     */
    public function setSlug(string $slug): ItemMenu
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return ItemMenu
     */
    public function setRoute(string $route): ItemMenu
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param string $groupname
     *
     * @return ItemMenu
     */
    public function setGroupname(string $groupname): ItemMenu
    {
        $this->groupname = $groupname;

        return $this;
    }

    /**
     * @param bool $divider
     *
     * @return ItemMenu
     */
    public function setDivider(bool $divider): ItemMenu
    {
        $this->divider = $divider;

        return $this;
    }

    /**
     * @param bool $childs
     *
     * @return ItemMenu
     */
    public function setChilds(bool $childs): ItemMenu
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * @param int $sort
     *
     * @return ItemMenu
     */
    public function setSort(int $sort): ItemMenu
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @param array $badge
     *
     * @return ItemMenu
     */
    public function setBadge(array $badge): ItemMenu
    {
        $this->badge = $badge;

        return $this;
    }
}