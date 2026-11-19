<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Illuminate\Contracts\Support\Arrayable;
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
     * The role(s) that were added to the user.
     *
     * @var Collection<array-key, mixed>
     */
    public $roles;

    /**
     * Create a new event instance.
     *
     * @param mixed                                                  $user The user to whom the role(s) is added
     * @param Arrayable<array-key, mixed>|iterable<mixed>|int|string $role The role(s) to be added
     */
    public function __construct(public mixed $user, mixed $role)
    {
        $this->roles = collect($role);
    }
}
