<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners\Settings;

use Orchid\Platform\Http\Forms\Settings\BaseSettingsForm;

class SettingBaseListener
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
        return BaseSettingsForm::class;
    }
}
