<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Events\Systems\SettingsEvent;

class SettingFormGroup extends FormGroup
{
    /**
     * @var string
     */
    public $view = 'dashboard::container.systems.settings.settings';

    /**
     * @var
     */
    public $event = SettingsEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Настройки',
            'description' => 'Глобальные настройки системы',
        ];
    }
}
