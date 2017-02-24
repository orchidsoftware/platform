<?php

namespace Orchid\Foundation\Listeners\Systems\Users;

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
     * @return
     *
     * @internal param UserEvent $event
     */
    public function handle()
    {
        return BaseUserForm::class;
    }
}
