<?php

namespace Orchid\Http\Forms\Systems\Settings;

use Orchid\Forms\Form;
use Orchid\Setting\Models\Setting;

class InfoForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
