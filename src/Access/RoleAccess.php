<?php

declare(strict_types=1);

namespace Orchid\Access;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;

trait RoleAccess
{
    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->getKey();
    }

    /**
     * @return string
     */
    public function getRoleSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers()
    {
        return $this->users()->get();
    }

    /**
     * The Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(User::class), 'role_users', 'role_id', 'user_id');
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if ($this->exists && !$isSoftDeleted) {
            $this->users()->detach();
        }

        return parent::delete();
    }
}
