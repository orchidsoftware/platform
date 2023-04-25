<?php

declare(strict_types=1);

namespace Orchid\Access;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;

trait RoleAccess
{
    use StatusAccess;

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->getKey();
    }

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
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(User::class), 'role_users', 'role_id', 'user_id');
    }

    /**
     * @return int
     */
    public function getCountPermissions(): int
    {
        return collect($this->permissions)->filter(fn (int $value) => $value)->count();
    }

    /**
     * @throws Exception
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
