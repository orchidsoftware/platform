<?php

namespace Orchid\Foundation\Events\Systems;

use Illuminate\Queue\SerializesModels;
use Orchid\Foundation\Http\Forms\Systems\Roles\RoleFormGroup;

class RolesEvent
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
     * @param FormGroup $form
     */
    public function __construct(RoleFormGroup $form)
    {
        $this->form = $form;
    }
}
