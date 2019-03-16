<?php

declare(strict_types=1);

namespace Orchid\Platform;

class ItemPermission
{
    /**
     * @var string
     */
    public $group;

    /**
     * @var array[]
     */
    public $items = [];

    /**
     * @deprecated
     *
     * @param string $group
     *
     * @return ItemPermission
     */
    public static function setGroup(string $group): self
    {
        return self::group($group);
    }

    /**
     * @param string $group
     *
     * @return ItemPermission
     */
    public static function group(string $group): self
    {
        $item = new self();

        $item->group = $group;

        return $item;
    }

    /**
     * @param string $slug
     * @param string $name
     *
     * @return $this
     */
    public function addPermission(string $slug, string $name)
    {
        $this->items[] = [
            'slug'        => $slug,
            'description' => $name,
        ];

        return $this;
    }
}
