<?php

namespace Orchid\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Alert\Facades\Alert;
use Orchid\Http\Controllers\Controller;
use Orchid\Http\Forms\Systems\Settings\SettingFormGroup;

class SettingController extends Controller
{
    /**
     * @var SettingFormGroup
     */
    public $form;

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
        return $this->form
            ->route('dashboard.systems.settings.update')
            ->method('post')
            ->render();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->form->save($request);
        Cache::flush();

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }
}
