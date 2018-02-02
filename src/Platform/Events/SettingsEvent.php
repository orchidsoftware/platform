<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Orchid\Platform\Http\Forms\Settings\SettingFormGroup;

class SettingsEvent
{
    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     *
     * @param SettingFormGroup $form
     */
    public function __construct(SettingFormGroup $form)
    {
        $this->form = $form;
    }
}
