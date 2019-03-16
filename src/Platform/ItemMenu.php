<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ItemMenu
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $icon = '';

    /**
     * @var string
     */
    public $route = '#';

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
    public $divider = false;

    /**
     * @var bool
     */
    public $childs = false;

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
     * @var array
     */
    public $active = [];

    /**
     * @var string
     */
    public $permission;

    /**
     * @param string $permission
     *
     * @return ItemMenu
     */
    public function permission(string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param string $permission
     *
     * @return ItemMenu
     */
    public function setPermission(string $permission): self
    {
       return $this->permission($permission);
    }

    /**
     * @param string|array $active
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function active($active): self
    {
        $this->active = Arr::wrap($active);

        return $this;
    }

    /**
     * @deprecated
     *
     * @param string|array $active
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function setActive($active): self
    {
        return $this->active($active);
    }

    /**
     * @param string $label
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public static function label(string $label): self
    {
        $item = new self();

        $item->label = $label;
        $item->slug = Str::slug($label);

        return $item;
    }

    /**
     * @deprecated
     *
     * @param string $label
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public static function setLabel(string $label): self
    {
        return self::label($label);
    }

    /**
     * @param string $icon
     *
     * @return ItemMenu
     */
    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param string $icon
     *
     * @return ItemMenu
     */
    public function setIcon(string $icon): self
    {
        return $this->icon($icon);
    }

    /**
     * @param bool $show
     *
     * @return ItemMenu
     */
    public function show(bool $show): self
    {
        $this->show = $show;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param bool $show
     *
     * @return ItemMenu
     */
    public function setShow(bool $show): self
    {
        return $this->show($show);
    }

    /**
     * @param string $slug
     *
     * @return ItemMenu
     */
    public function slug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param string $slug
     *
     * @return ItemMenu
     */
    public function setSlug(string $slug): self
    {
        return $this->slug($slug);
    }

    /**
     * @deprecated
     *
     * Generate the URL to a named route.
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return ItemMenu
     */
    public function setRoute(string $name, array $parameters = [], bool $absolute = true): self
    {
        return $this->route($name, $parameters, $absolute);
    }

    /**
     * Generate the URL to a named route.
     *
     * @param string $name
     * @param array  $parameters
     * @param bool   $absolute
     *
     * @return ItemMenu
     */
    public function route(string $name, array $parameters = [], bool $absolute = true): self
    {
        $this->route = route($name, $parameters, $absolute);

        $this->active([$this->route, $this->route.'/*']);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return ItemMenu
     */
    public function url(string $url) : self
    {
        $this->route = $url;

        $this->active($url);

        return $this;
    }

    /**
     * @deprecated
     *
     * @param string $url
     *
     * @return ItemMenu
     */
    public function setUrl(string $url) : self
    {
        return $this->url($url);
    }

    /**
     * @param string $groupname
     *
     * @return ItemMenu
     */
    public function groupName(string $groupname = null): self
    {
            $this->groupname = $groupname;

            return $this;
    }

    /**
     * @deprecated
     *
     * @param string $groupname
     *
     * @return ItemMenu
     */
    public function setGroupName(string $groupname = null): self
    {
        return $this->groupName($groupname);
    }

    /**
     * @deprecated
     *
     * @param bool $divider
     *
     * @return ItemMenu
     */
    public function setDivider(bool $divider): self
    {
        return $this->divider($divider);
    }

    /**
     * @param bool $divider
     *
     * @return ItemMenu
     */
    public function divider(bool $divider): self
    {
        $this->divider = $divider;

        return $this;
    }

    /**
     * @param bool $childs
     *
     * @return ItemMenu
     */
    public function childs(bool $childs = true): self
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param bool $childs
     *
     * @return ItemMenu
     */
    public function setChilds(bool $childs = true): self
    {
        return $this->childs($childs);
    }

    /**
     * @param int $sort
     *
     * @return ItemMenu
     */
    public function sort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @deprecated
     *
     * @param int $sort
     *
     * @return ItemMenu
     */
    public function setSort(int $sort): self
    {
        return $this->sort($sort);
    }

    /**
     * @deprecated
     *
     * @param \Closure $badge
     * @param string   $class
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function setBadge(\Closure $badge, string $class = 'bg-primary'): self
    {
        return $this->badge($badge, $class);
    }

    /**
     * @param \Closure $badge
     * @param string   $class
     *
     * @return \Orchid\Platform\ItemMenu
     */
    public function badge(\Closure $badge, string $class = 'bg-primary'): self
    {
        $this->badge = [
            'class' => $class,
            'data'  => $badge,
        ];

        return $this;
    }
}
