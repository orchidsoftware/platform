<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RemoveRoleEvent
{
    use SerializesModels;

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
    public function __construct(public mixed $user, mixed $role)
    {
        $this->roles = collect($role);
    }
}
