<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Settings\SettingFormGroup;

class SettingController extends Controller
{
    /**
     * @var
     */
    public $form = SettingFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->form->save($request);
        Cache::flush();

        return redirect()->back();
    }
}
