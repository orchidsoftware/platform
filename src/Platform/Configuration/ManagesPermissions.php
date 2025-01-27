<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Collection;
use Orchid\Platform\ItemPermission;

trait ManagesPermissions
{
    /**
     * Collection of permissions for the application.
     *
     * @var Collection
     */
    private $permission;

    /**
     * Registers a ItemPermission that defines authentication permissions.
     *
     * @return $this
     */
    public function registerPermissions(ItemPermission $permission): self
    {
        if (empty($permission->group)) {
            return $this;
        }

        $old = $this->permission->get('all')
            ->get($permission->group, []);

        $this->permission->get('all')
            ->put($permission->group, array_merge_recursive($old, $permission->items));

        return $this;
    }

    /**
     * Retrieve permissions based on specified groups.
     *
     * @param array|string $groups
     */
    public function getPermission($groups = []): Collection
    {
        $all = $this->permission->get('all')
            ->when(! empty($groups), fn (Collection $collection) => $collection->only($groups));

        $removed = $this->permission->get('removed');

        if (! $removed->count()) {
            return $all;
        }

        return $all->map(static function ($group) use ($removed) {
            foreach ($group[key($group)] as $key => $item) {
                if ($removed->contains($item)) {
                    unset($group[key($group)]);
                }
            }

            return $group;
        });
    }

    /**
     * Get all registered permissions with the enabled state.
     *
     * @param array|string $groups
     */
    public function getAllowAllPermission($groups = []): Collection
    {
        return $this->getPermission($groups)
            ->collapse()
            ->reduce(static fn (Collection $permissions, array $item) => $permissions->put($item['slug'], true), collect());
    }

    /**
     * Remove a specific permission by key.
     *
     * @return $this
     */
    public function removePermission(string $key): self
    {
        $this->permission->get('removed')->push($key);

        return $this;
    }
}
