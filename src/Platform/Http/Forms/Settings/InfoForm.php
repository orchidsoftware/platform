<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Settings;

use Orchid\Platform\Forms\Form;
use Orchid\Platform\Core\Models\Setting;

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
     * InfoForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::systems/settings.tabs.information');
        parent::__construct($request);
    }

    /**
     * Display Settings App.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get()
    {
        $settings = collect(config('app'));
        $extendSettings = $this->model->get('base', collect());
        $settings = $settings->merge($extendSettings);

        return view('dashboard::container.systems.settings.info', [
            'settings' => $settings,
        ]);
    }
}
