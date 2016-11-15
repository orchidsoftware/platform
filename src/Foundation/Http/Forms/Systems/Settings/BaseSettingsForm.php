<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Core\Models\Setting;
use Orchid\Foundation\Services\Forms\Form;

class BaseSettingsForm extends Form
{
    public $name = 'Base';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Setting::class;


    /**
     * Validation Rules Request.
     *
     * @var array
     */
    protected $rules = [
        'settings' => 'required|array',
    ];

    /**
     * Display Settings App.
     */
    public function get()
    {
        $settings = $this->model->get('base', collect());

        return view('dashboard::container.systems.settings.base', [
            'settings' => $settings,
        ]);
    }

    /**
     * Save Base Settings.
     */
    public function persist()
    {
        $settings = $this->request->input('settings');
        foreach ($settings as $key => $value) {
            $this->model->set($key, $value);
        }

        return response()->json([
            'title'   => 'Успешно',
            'message' => 'Данные сохранены',
        ]);
    }

    public function grid()
    {
        // TODO: Implement grid() method.
    }
}
