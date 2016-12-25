<?php

namespace Orchid\Access;

trait UserAccess
{
    /**
     * Returns the roles model.
     *
     * @return string
     */
    public static function getRolesModel()
    {
        return static::$rolesModel;
    }

    /**
     * Sets the roles model.
     *
     * @param string $rolesModel
     */
    public static function setRolesModel($rolesModel)
    {
        static::$rolesModel = $rolesModel;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param $role
     *
     * @return bool
     */
    public function inRole($role)
    {
        $role = array_first($this->roles, function ($index, $instance) use ($role) {
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
     * @param $сheckPermissions
     *
     * @return bool
     */
    public function hasAccess($сheckPermissions)
    {
        $Permissions = $this->roles()->pluck('permissions');
        $Permissions->prepend($this->permissions);

        foreach ($Permissions as $Permission) {
            if (isset($Permission[$сheckPermissions]) && $Permission[$сheckPermissions]) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id');
    }

    /**
     * @param $role
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles()->save($role);
    }

    /**
     * @param $role
     */
    public function removeRole(RoleInterface $role)
    {
        $this->roles()->where('slug', $role->getRoleSlug())->first()->remove();
    }

    /**
     * Remove Role Slug.
     * @param $slug
     */
    public function removeRoleBySlug($slug)
    {
        $this->roles()->where('slug', $slug)->first()->remove();
    }

    /**
     * @param array
     */
    public function replaceRoles($roles)
    {
        $this->roles()->detach();
        $this->roles()->attach($roles);
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if ($this->exists && ! $isSoftDeleted) {
            $this->roles()->detach();
        }

        return parent::delete();
    }
}
