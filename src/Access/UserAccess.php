<?php

declare(strict_types=1);

namespace Orchid\Access;

use Exception;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Orchid\Platform\Events\AddRoleEvent;
use Orchid\Platform\Events\RemoveRoleEvent;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Orchid;

trait UserAccess
{
    use StatusAccess;

    /**
     * @var null|Collection<int, Permissions>
     */
    private $cachePermissions;

    /**
     * Return the user's role assignments.
     *
     * @return BelongsToMany<Model, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Orchid::model(Role::class), 'role_users', 'user_id', 'role_id');
    }

    /**
     * Check membership by role model, name, or key.
     *
     * @param mixed $role
     */
    public function inRole($role): bool
    {
        if ($role instanceof Model) {
            return $this->roles()->whereKey($role->getKey())->exists();
        }

        if (! is_string($role) && ! is_int($role)) {
            return false;
        }

        return $this->roles()
            ->where(function (Builder $builder) use ($role) {
                $builder->whereKey($role);

                if (is_string($role)) {
                    $builder->orWhere('name', $role);
                }
            })
            ->exists();
    }

    /**
     * Check whether user or role permissions grant the requested permission.
     */
    public function hasAccess(string $permit, bool $cache = true): bool
    {
        if (! $cache || $this->cachePermissions === null) {
            $this->cachePermissions = $this->roles()
                ->pluck('permissions')
                ->prepend($this->permissions)
                ->map(fn ($permission) => Permissions::make($permission))
                ->filter(fn (Permissions $permission) => ! $permission->isEmpty());
        }

        return $this->cachePermissions
            ->filter(fn (Permissions $permissions) => $permissions->allows($permit))
            ->isNotEmpty();
    }

    /**
     * This method will grant access if any permission passes the check.
     *
     * @param string|iterable<array-key, string>|null $permissions
     */
    public function hasAnyAccess($permissions, bool $cache = true): bool
    {
        if (empty($permissions)) {
            return true;
        }

        foreach (is_string($permissions) ? [$permissions] : $permissions as $permit) {
            if ($this->hasAccess($permit, $cache)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Query Scope for retrieving users by a certain permission
     * The * character usage is not implemented.
     *
     * @param Builder<static> $builder
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function byAccess(Builder $builder, string $permitWithoutWildcard): Builder
    {
        if (empty($permitWithoutWildcard)) {
            return $builder->whereRaw('1=0');
        }

        return $this->byAnyAccess($builder, $permitWithoutWildcard);
    }

    /**
     * Query Scope for retrieving users by any permissions
     * The * character usage is not implemented.
     *
     * @param Builder<static>                    $builder
     * @param string|iterable<array-key, string> $permitsWithoutWildcard
     *
     * @return Builder<static>
     */
    #[Scope]
    protected function byAnyAccess(Builder $builder, $permitsWithoutWildcard): Builder
    {
        $columns = [];

        foreach (is_string($permitsWithoutWildcard) ? [$permitsWithoutWildcard] : $permitsWithoutWildcard as $permit) {
            $columns[] = 'permissions->'.$permit;
        }

        if ($columns === []) {
            return $builder->whereRaw('1=0');
        }

        return $builder
            ->whereAny($columns, '=', true)
            ->orWhereHas('roles', fn (Builder $query) => $query->whereAny($columns, '=', true));
    }

    /**
     * Assign a role, dispatch its event and invalidate cached permissions.
     */
    public function addRole(Model $role): Model
    {
        $result = $this->roles()->save($role);

        $this->eventAddRole($role);
        $this->clearCachePermission();

        return $result;
    }

    /**
     * @return $this
     */
    public function removeRole(Model $role)
    {
        $this->roles()->detach($role->getKey());

        $this->eventRemoveRole($role);
        $this->clearCachePermission();

        return $this;
    }

    /**
     * @return $this
     */
    public function removeRoleBySlug(string $slug)
    {
        $role = $this->roles()
            ->where('name', $slug)
            ->first();

        if ($role === null) {
            return $this;
        }

        return $this->removeRole($role);
    }

    /**
     * @param array<array-key, int|string|Model|array<string, mixed>>|null $roles
     *
     * @return $this
     */
    public function replaceRoles(?array $roles = [])
    {
        $changes = $this->roles()->sync($roles ?? []);

        $this->clearCachePermission();

        if ($changes['detached'] !== []) {
            $this->eventRemoveRole($changes['detached']);
        }

        if ($changes['attached'] !== []) {
            $this->eventAddRole($changes['attached']);
        }

        return $this;
    }

    /**
     * @param Model|int|string|array<array-key, mixed> $roles
     *
     * @return void
     */
    public function eventAddRole($roles)
    {
        event(new AddRoleEvent($this, $roles));
    }

    /**
     * @param Model|int|string|array<array-key, mixed> $roles
     *
     * @return void
     */
    public function eventRemoveRole($roles)
    {
        event(new RemoveRoleEvent($this, $roles));
    }

    /**
     * @throws Exception
     */
    public function delete(): bool
    {
        $isSoftDeleted = array_key_exists(SoftDeletes::class, class_uses($this));

        if ($this->exists && ! $isSoftDeleted) {
            $this->roles()->detach();
        }

        return parent::delete();
    }

    /**
     * Clear the cached user and role permissions.
     */
    public function clearCachePermission(): self
    {
        $this->cachePermissions = null;

        return $this;
    }
}
