<?php

namespace Orchid\Access;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RoleAccess
{
    /**
     * @return mixed
     */
    public static function getUsersModel()
    {
        return static::$usersModel;
    }

    /**
     * @param $usersModel
     */
    public static function setUsersModel($usersModel)
    {
        static::$usersModel = $usersModel;
    }

    /**
     * The Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(static::$usersModel, 'role_users', 'role_id', 'user_id')->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getRoleId() : int
    {
        return $this->getKey();
    }

    /**
     * @return mixed
     */
    public function getRoleSlug() : string
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function delete() : bool
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if ($this->exists && !$isSoftDeleted) {
            $this->users()->detach();
        }

        return parent::delete();
    }
}
