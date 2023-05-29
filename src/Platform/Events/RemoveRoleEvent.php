<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Orchid\Platform\Models\User;

class RemoveRoleEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var User
     */
    public $user;

    /**
     * Roles that will be removed.
     *
     * @var Collection
     */
    public $roles;

    /**
     * Create a new event instance.
     *
     * @param mixed $user The user object this event relates to.
     * @param mixed $role The role(s) to remove. Can accept either a Collection or an array.
     */
    public function __construct($user, $role)
    {
        $this->user = $user;
        $this->roles = collect($role);
    }
}
