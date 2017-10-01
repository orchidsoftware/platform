<?php

namespace Orchid\Platform\Listeners\Systems\Users;

use Orchid\Platform\Http\Forms\Systems\Users\AccessUserForm;

class UserAccessListener
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
     * @return string
     *
     * @internal param UserEvent $event
     */
    public function handle() : string
    {
        return AccessUserForm::class;
    }
}
