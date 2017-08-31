<?php

namespace Orchid\Platform\Events\User;

use Illuminate\Queue\SerializesModels;
use Orchid\Platform\Http\Forms\Systems\Roles\RoleFormGroup;

class RemovedFromTeam
{
    use SerializesModels;

    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     *
     * @param RoleFormGroup $form
     */
    public function __construct(RoleFormGroup $form)
    {
        $this->form = $form;
    }
}
