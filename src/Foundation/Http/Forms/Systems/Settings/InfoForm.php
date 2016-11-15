<?php namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Services\Forms\Form;
use Orchid\Foundation\Core\Models\Setting;

class InfoForm extends Form
{
    public $name = 'Info';

    /**
     * Base Model
     * @var
     */
    protected $model = Setting::class;


    /**
     * Display Settings App
     */
    public function get()
    {
        $settings = collect(
            config('app')
        );
        $extendSettings = $this->model->get('base', collect());
        $settings = $settings->merge($extendSettings);

        return view('dashboard::container.systems.settings.info', [
            'settings' => $settings
        ]);
    }


    public function persist()
    {
        // TODO: Implement persist() method.
    }


    public function grid()
    {
        // TODO: Implement grid() method.
    }
}
