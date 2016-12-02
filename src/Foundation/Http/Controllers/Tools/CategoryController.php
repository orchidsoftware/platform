<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Orchid\Foundation\Http\Controllers\Controller;

class CategoryController extends Controller
{

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

    /**]
     * @return mixed
     */
    public function store()
    {
        $this->form->save();

        return redirect()->back();
    }

}