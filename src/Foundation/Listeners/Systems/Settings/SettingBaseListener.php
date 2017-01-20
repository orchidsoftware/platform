<?php

namespace Orchid\Foundation\Listeners\Systems\Settings;

use Orchid\Foundation\Events\Systems\SettingsEvent;
use Orchid\Foundation\Http\Forms\Systems\Settings\BaseSettingsForm;

class SettingBaseListener
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
     * @param SettingsEvent $event
     */
    public function handle(SettingsEvent $event)
    {
        return BaseSettingsForm::class;
    }
}
