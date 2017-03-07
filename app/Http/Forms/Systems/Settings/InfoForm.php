<?php

namespace Orchid\Http\Forms\Systems\Settings;

use Orchid\Core\Models\Setting;
use Orchid\Forms\Form;

class InfoForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Info';

    /**
     * @var string
     */
    public $icon = 'fa fa-cogs';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Setting::class;

    /**
     * Display Settings App.
     */
    public function get()
    {
        $settings = collect(
            config('app')
        );
        $extendSettings = $this->model->get('base', collect());
        $settings = $settings->merge($extendSettings);

        return view('dashboard::container.systems.settings.info', [
            'settings' => $settings,
        ]);
    }
}
