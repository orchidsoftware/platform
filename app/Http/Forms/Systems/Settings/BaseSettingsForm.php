<?php

namespace Orchid\Http\Forms\Systems\Settings;

use Illuminate\Contracts\View\View;
use Orchid\Forms\Form;
use Orchid\Setting\Models\Setting;

class BaseSettingsForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Settings';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Setting::class;

    /**
     * Display Settings App.
     *
     * @return View
     */
    public function get(): View
    {
        $settings = $this->model->get([
            'site_title',
            'site_keywords',
            'site_description',
            'site_adress',
            'site_phone',
            'site_email',
        ], []);

        return view('dashboard::container.systems.settings.base', $settings);
    }

    /**
     * Save Base Settings.
     */
    public function persist()
    {
        $settings = $this->request->except('_token');
        foreach ($settings as $key => $value) {
            $this->model->set($key, $value);
        }
    }
}
