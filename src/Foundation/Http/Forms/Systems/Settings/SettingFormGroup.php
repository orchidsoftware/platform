<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Events\Systems\SettingsEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class SettingFormGroup extends FormGroup
{
    /**
     * @var string
     */
    public $view = 'dashboard::container.systems.settings.settings';
    /**
     * Route available list.
     * @var array
     */
    public $route = [
        'index' => [
            'method' => 'GET',
            'name' => 'dashboard.systems.settings',
        ],
        'update' => [
            'method' => 'PUT',
            'name' => 'dashboard.systems.settings.update',
        ],
    ];


    /**
     * @var
     */
    public $event = SettingsEvent::class;

    /**
     * Description Attributes for group.
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Настройки',
            'description' => 'Глобавльные настройки системы',
        ];
    }
}
