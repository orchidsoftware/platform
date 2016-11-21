<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Settings\SettingFormGroup;
use Illuminate\Support\Facades\Cache;

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
        return $this->form->render();
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
