<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Orchid\Platform\Models\User;

/**
 * This event is triggered when a role is added to a user.
 */
class AddRoleEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var User
     */
    public $user;

    /**
     * The role(s) that were added to the user.
     *
     * @var Collection
     */
    public $roles;

    /**
     * Create a new event instance.
     *
     * @param mixed $user The user to whom the role(s) is added
     * @param mixed $role The role(s) to be added
     */
    public function __construct($user, $role)
    {
        $this->user = $user;
        $this->roles = collect($role);
    }
}
