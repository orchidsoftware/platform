<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Orchid\Access\PermissionGroup;

/**
 * @deprecated Use \Orchid\Access\PermissionGroup instead.
 */
class ItemPermission extends PermissionGroup
{
    /**
     * Backward-compatible alias for PermissionGroup::$name.
     */
    public string $group;

    /**
     * Backward-compatible alias for the permission definitions.
     *
     * @var array<int, array{slug: string, description: string}>
     */
    public array $items;

    /**
     * @param array<int, array{slug: string, description: string}> $items
     *
     * @psalm-suppress UnsupportedPropertyReferenceUsage Psalm cannot analyze property aliases.
     */
    public function __construct(string $name, array $items = [])
    {
        parent::__construct($name, $items);

        $this->group = &$this->name;
        $this->items = &$this->definitions;
    }

    /**
     * Create a permission group using the legacy factory name.
     */
    #[\Deprecated(message: 'Use Orchid\Access\PermissionGroup::make() instead.')]
    public static function group(string $name): static
    {
        return new static($name);
    }

    /**
     * Add a permission using the legacy method name.
     */
    #[\Deprecated(message: 'Use Orchid\Access\PermissionGroup::add() instead.')]
    public function addPermission(string $slug, string $description): static
    {
        return $this->add($slug, $description);
    }
}
