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
     * @var bool
     */
    public $divider;

    /**
     * @var bool
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
    public function setPermission(string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @param string $active
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param $label
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public static function setLabel(string $label): self
    {
        $item = new self();

        $item->label = $label;
        $item->slug  = str_slug($label);

        return $item;
    }

    /**
     * @param string $icon
     *
     * @return ItemMenu
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param bool $show
     *
     * @return ItemMenu
     */
    public function setShow(bool $show): self
    {
        $this->show = $show;

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return ItemMenu
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param string $route
     *
     * @return ItemMenu
     */
    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param string $groupname
     *
     * @return ItemMenu
     */
    public function setGroupName(string $groupname = null): self
    {
        $this->groupname = $groupname;

        return $this;
    }

    /**
     * @param bool $divider
     *
     * @return ItemMenu
     */
    public function setDivider(bool $divider): self
    {
        $this->divider = $divider;

        return $this;
    }

    /**
     * @param bool $childs
     *
     * @return ItemMenu
     */
    public function setChilds(bool $childs): self
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * @param int $sort
     *
     * @return ItemMenu
     */
    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @param \Closure $badge
     * @param string $class
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function setBadge(\Closure $badge, string $class = 'bg-primary'): self
    {
        $this->badge = [
            'class' => $class,
            'data'  => $badge,
        ];

        return $this;
    }
}
