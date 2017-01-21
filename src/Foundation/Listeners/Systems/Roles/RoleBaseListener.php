<?php

namespace Orchid\Foundation\Listeners\Systems\Roles;

use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Http\Forms\Systems\Roles\BaseRolesForm;

class RoleBaseListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param RolesEvent $event
     */
    public function handle(RolesEvent $event)
    {
        return BaseRolesForm::class;
    }
}
