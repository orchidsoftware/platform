<?php namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Events\Systems\SettingsEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

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
}
