<?php

namespace Orchid\Foundation\Listeners\Systems\Roles;

use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Http\Forms\Systems\Settings\BaseRolesForm;

class RoleBaseListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param RolesEvent $event
     *
     * @return void
     */
    public function handle(RolesEvent $event)
    {
        return BaseRolesForm::class;
    }
}
