<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners\Systems\Users;

use Orchid\Platform\Http\Forms\Systems\Users\BaseUserForm;

class UserBaseListener
{
    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param UserEvent $event
     */
    public function handle() : string
    {
        return BaseUserForm::class;
    }
}
