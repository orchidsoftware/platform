<?php

namespace Orchid\Platform\Events\Systems\Roles;

use Illuminate\Queue\SerializesModels;
use Orchid\Platform\Core\Models\User;

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
     * Roles
     *
     * @var array
     */
    public $roles = [];

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $role
     */
    public function __construct($user, $role)
    {
        $this->user = $user;

        if (is_array($role)) {
            $this->roles = $role;
        } else {
            $this->roles[] = $role;
        }
    }
}
