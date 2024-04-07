<?php

declare(strict_types=1);

namespace Orchid\Platform;

/**
 * This class represents a permission group that can be used to store collections of permissions.
 */
class ItemPermission
{
    /**
     * The name of the permission group.
     *
     * @var string
     */
    public $group;

    /**
     * The list of permissions in the group.
     *
     * @var array[]
     */
    public $items = [];

    /**
     * Create a new permission group instance with the given group name.
     *
     * @param string $group The name of the permission group.
     *
     * @return self The new permission group instance.
     */
    public static function make(string $group, array $items = []): self
    {
        $item = new self();

        $item->group = $group;

        foreach ($items as $slug => $name){
            $item->add($slug, $name);
        }

        return $item;
    }

    /**
     * Create a new permission group instance with the given group name.
     *
     * @param string $group The name of the permission group.
     *
     * @return self The new permission group instance.
     */
    public static function group(string $group, array $items = []): self
    {
        return self::make($group, $items);
    }

    /**
     * Add a permission to the permission group.
     *
     * @param string $slug The slug of the permission.
     * @param string $name The description of the permission.
     *
     * @return $this The current permission group instance.
     */
    public function add(string $slug, string $name): self
    {
        $this->items[] = [
            'slug'        => $slug,
            'description' => $name,
        ];

        return $this;
    }

    /**
     * @alias
     *
     * Alice for `add` method
     *
     * @param string $slug The slug of the permission.
     * @param string $name The description of the permission.
     *
     * @return $this The current permission group instance.
     */
    public function addPermission(string $slug, string $name): self
    {
        return $this->add($slug, $name);
    }
}
