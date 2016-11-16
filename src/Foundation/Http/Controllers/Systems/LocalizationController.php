<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Localization\LocalizationFormGroup;
use Orchid\Foundation\Services\Forms\CrudFormTrait;

class LocalizationController extends Controller
{
    use CrudFormTrait;

    /**
     * @var
     */
    public $form = LocalizationFormGroup::class;

    /**
     * LocalizationController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    public function index()
    {
        return $this->form->grid();
    }

    public function get()
    {
        return $this->form->render();
    }
}
