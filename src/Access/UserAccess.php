<?php

namespace Orchid\Platform\Access;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Events\Systems\Roles\AddRoleEvent;
use Orchid\Platform\Events\Systems\Roles\RemoveRoleEvent;

trait UserAccess
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles()
    {
        return $this->roles()->get();
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function inRole($role) : bool
    {
        $role = array_first($this->roles, function ($instance) use ($role) {
            if ($role instanceof RoleInterface) {
                return $instance->getRoleId() === $role->getRoleId();
            }
            if ($instance->getRoleId() == $role || $instance->getRoleSlug() == $role) {
                return true;
            }

            return false;
        });

        return $role !== null;
    }

    /**
     * @param $checkPermissions
     *
     * @return bool
     */
    public function hasAccess($checkPermissions) : bool
    {
        $permissions = $this->roles()->pluck('permissions');
        $permissions->prepend($this->permissions);

        foreach ($permissions as $permission) {
            if (isset($permission['superuser'])) {
                return true;
            }

            if (isset($permission[$checkPermissions]) && $permission[$checkPermissions]) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    /**
     * @param Model $role
     *
     * @return Model
     */
    public function addRole(Model $role) : Model
    {
        $result =  $this->roles()->save($role);

        event(new AddRoleEvent($this, $role));

        return $result;
    }

    /**
     * @param RoleInterface $role
     *
     * @return bool
     */
    public function removeRole(RoleInterface $role) : bool
    {
        $result = $this->roles()->where('slug', $role->getRoleSlug())->first()->remove();

        event(new RemoveRoleEvent($this, $role));

        return $result;
    }

    /**
     * Remove Role Slug.
     *
     * @param $slug
     *
     * @return bool
     */
    public function removeRoleBySlug($slug) : bool
    {
        $role = $this->roles()->where('slug', $slug)->first();

        return $this->removeRole($role);
    }

    /**
     * @param array
     */
    public function replaceRoles($roles)
    {
        $this->roles()->detach();

        event(new RemoveRoleEvent($this, $roles));

        $this->roles()->attach($roles);

        event(new AddRoleEvent($this, $roles));
    }

    /**
     * @return bool
     */
    public function delete() : bool
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if ($this->exists && !$isSoftDeleted) {
            $this->roles()->detach();
        }

        return parent::delete();
    }
}
