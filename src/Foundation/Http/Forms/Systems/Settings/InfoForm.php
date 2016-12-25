<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Setting;

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

    public function persist()
    {
    }
}
