<?php

namespace Orchid\Foundation\Listeners\Systems\Settings;

use Orchid\Foundation\Events\Systems\SettingsEvent;
use Orchid\Foundation\Http\Forms\Systems\Settings\BaseSettingsForm;

class SettingBaseListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param SettingsEvent $event
     *
     * @return void
     */
    public function handle(SettingsEvent $event)
    {
        return BaseSettingsForm::class;
    }
}
