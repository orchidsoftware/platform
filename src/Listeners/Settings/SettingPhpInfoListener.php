<?php

namespace Orchid\Platform\Listeners\Settings;

use Orchid\Platform\Http\Forms\Settings\PhpInfoForm;

class SettingPhpInfoListener
{
    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param SettingsEvent $event
     */
    public function handle() : string
    {
        return PhpInfoForm::class;
    }
}
