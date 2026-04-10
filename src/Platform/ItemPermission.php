<?php

declare(strict_types=1);

namespace Orchid\Platform;

/**
 * This class represents a permission group that can be used to store collections of permissions.
 */
class ItemPermission
{
    /**
     * Create a new permission group instance.
     */
    public function __construct(
        public string $group,
        public array  $items = []
    )
    {
    }

    /**
     * Create a new permission group instance with the given group name.
     *
     * @param string $group The name of the permission group.
     *
     * @return self The new permission group instance.
     */
    public static function group(string $group): self
    {
        $item = new self($group);

        return $item;
    }

    /**
     * Add a permission to the permission group.
     *
     * @param string $slug The slug of the permission.
     * @param string $name The description of the permission.
     *
     * @return $this The current permission group instance.
     */
    public function addPermission(string $slug, string $name): self
    {
        $this->items[] = [
            'slug'        => $slug,
            'description' => $name,
        ];

        return $this;
    }
}
