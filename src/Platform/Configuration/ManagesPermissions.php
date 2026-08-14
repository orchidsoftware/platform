<?php

namespace Orchid\Platform\Configuration;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Orchid\Access\PermissionGroup;
use Orchid\Access\Permissions;

trait ManagesPermissions
{
    /**
     * A registry of all registered permissions, grouped by category.
     *
     * @var array<string, array<int, array{slug: string, description: string}>>
     */
    protected array $registeredPermissions = [];

    /**
     * A list of revoked permission slugs.
     *
     * @var string[]
     */
    protected array $removedPermissions = [];

    /**
     * Register a permission group with the dashboard catalog.
     */
    public function registerPermissionGroup(PermissionGroup $group): static
    {
        $old = Arr::get($this->registeredPermissions, $group->name, []);

        $this->registeredPermissions[$group->name] = array_merge($old, $group->definitions());

        return $this;
    }

    /**
     * Retrieve permissions based on specified groups.
     *
     * @param array|string $groups
     *
     * @return Collection<string, Collection<int, array{slug: string, description: string}>>
     */
    public function permissionGroups(string|array $groups = []): Collection
    {
        return collect($this->registeredPermissions)
            ->when(! empty($groups), fn (Collection $collection) => $collection->only($groups))
            ->map(fn ($group) => collect($group)->whereNotIn('slug', $this->removedPermissions));
    }

    /**
     * Get all registered permissions with the enabled state.
     *
     * @param array|string $groups
     *
     * @return Permissions Assigned permission states keyed by slug.
     */
    public function allowedPermissions(string|array $groups = []): Permissions
    {
        return Permissions::fromDefinitions($this->permissionGroups($groups)->collapse());
    }

    /**
     * Remove a specific permission by key.
     *
     * @param string $key
     *
     * @return static
     */
    public function removePermission(string $key): static
    {
        $this->removedPermissions[] = $key;

        return $this;
    }
}
