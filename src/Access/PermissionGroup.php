<?php

declare(strict_types=1);

namespace Orchid\Access;

/**
 * A named group of permissions registered with Orchid.
 *
 * Groups describe the available permission catalog. Assigned permission
 * states are stored separately by the Permissions cast.
 */
class PermissionGroup
{
    /**
     * @param array<int, array{slug: string, description: string}> $items
     */
    public function __construct(
        public string $name,
        public array $items = []
    ) {}

    /**
     * Create a new permission group.
     */
    public static function group(string $name): static
    {
        return new static($name);
    }

    /**
     * Register a permission in the group.
     */
    public function permission(string $slug, string $description): static
    {
        $this->items[] = [
            'slug'        => $slug,
            'description' => $description,
        ];

        return $this;
    }

    /**
     * Add a permission definition to the group.
     */
    public function addPermission(string $slug, string $description): static
    {
        return $this->permission($slug, $description);
    }

    /**
     * @return array<int, array{slug: string, description: string}>
     */
    public function items(): array
    {
        return $this->items;
    }
}
