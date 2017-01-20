<?php

namespace Orchid\Foundation\Listeners\Systems\Users;

use Orchid\Foundation\Events\Systems\UserEvent;
use Orchid\Foundation\Http\Forms\Systems\Users\BaseUserForm;

class UserBaseListener
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
     * @param UserEvent $event
     */
    public function handle(UserEvent $event)
    {
        return BaseUserForm::class;
    }
}
