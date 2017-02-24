<?php

namespace Orchid\Foundation\Listeners\Systems\Roles;

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
     * @return
     *
     * @internal param RolesEvent $event
     */
    public function handle()
    {
        return BaseRolesForm::class;
    }
}
