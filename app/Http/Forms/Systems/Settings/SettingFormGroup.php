<?php

namespace Orchid\Http\Forms\Systems\Settings;

use Orchid\Events\Systems\SettingsEvent;
use Orchid\Forms\FormGroup;

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
    public function attributes() : array
    {
        return [
            'name'        => 'Настройки',
            'description' => 'Глобальные настройки системы',
        ];
    }
}
