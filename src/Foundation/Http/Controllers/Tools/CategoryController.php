<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Tools\Category\CategoryFormGroup;

class CategoryController extends Controller
{
    /**
     * @var
     */
    public $form = CategoryFormGroup::class;

    /**
     * LocalizationController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    /**
     * @return mixed
     */
    public function create(){
        return $this->form->render();
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
