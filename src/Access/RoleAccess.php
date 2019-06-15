<?php

declare(strict_types=1);

namespace Orchid\Access;

use Exception;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        return $this->getAttribute('slug');
    }

    /**
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users()->get();
    }

    /**
     * The Users relationship.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(User::class), 'role_users', 'role_id', 'user_id');
    }

    /**
     * @throws Exception
     *
     * @return bool|null
     */
    public function delete(): ?bool
    {
        $isSoftDeleted = array_key_exists(SoftDeletes::class, class_uses($this));
        if ($this->exists && ! $isSoftDeleted) {
            $this->users()->detach();
        }

        return parent::delete();
    }
}
