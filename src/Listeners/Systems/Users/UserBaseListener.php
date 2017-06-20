<?php

namespace Orchid\Listeners\Systems\Users;

use Orchid\Http\Forms\Systems\Users\BaseUserForm;

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
     * @return string
     *
     * @internal param UserEvent $event
     */
    public function handle(): string
    {
        return BaseUserForm::class;
    }
}
