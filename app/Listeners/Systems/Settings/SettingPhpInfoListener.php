<?php

namespace Orchid\Listeners\Systems\Settings;

use Orchid\Http\Forms\Systems\Settings\PhpInfoForm;

class SettingPhpInfoListener
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
     * @internal param SettingsEvent $event
     */
    public function handle(): string
    {
        return PhpInfoForm::class;
    }
}
