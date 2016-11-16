<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Services\Forms\CrudFormTrait;
use Orchid\Foundation\Http\Forms\Systems\Localization\LocalizationFormGroup;

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
    public function __construct() {
        $this->form = new $this->form;
    }

    public function index() {
        return $this->form->grid();
    }

    public function get() {
        return $this->form->add();
    }
}
