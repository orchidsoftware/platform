<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers\Systems;

use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Forms\Settings\SettingFormGroup;

class SystemController extends Controller
{
    /**
     * SettingController constructor.
     *
     * @param SettingFormGroup $form
     */
    public function __construct(SettingFormGroup $form)
    {
        $this->checkPermission('dashboard.systems.settings');
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function index()
    {
        return view('dashboard::container.systems.index');
    }
}
