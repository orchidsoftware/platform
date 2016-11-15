<?php namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Settings\SettingFormGroup;

class SettingController extends Controller
{
    /**
     * @return string
     */
    public function index()
    {
        $form = new SettingFormGroup();

        return $form->render();
    }
}
