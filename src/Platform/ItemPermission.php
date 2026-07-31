<?php

declare(strict_types=1);

namespace Orchid\Platform;

use Orchid\Access\PermissionGroup;

/**
 * @deprecated Use \Orchid\Access\PermissionGroup instead.
 */
class ItemPermission extends PermissionGroup
{
    #[\Deprecated(message: 'Use Orchid\Access\PermissionGroup instead.')]
    public function __construct(string $name, array $items = [])
    {
        parent::__construct($name, $items);
    }

    #[\Deprecated(message: 'Use Orchid\Access\PermissionGroup::group() instead.')]
    public static function group(string $name): static
    {
        return parent::group($name);
    }
}
