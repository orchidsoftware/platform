<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 10:41
 */

namespace Orchid\Foundation\Http\Controllers\Tools;


use Orchid\Foundation\Http\Forms\Tools\Category\AdvertisingFormGroup;
use Orchid\Foundation\Http\Controllers\Controller;

class AdvertisingController extends Controller
{
    protected $formClass = AdvertisingFormGroup::class;
    protected $form = null;

    /**
     * AdvertisingController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->formClass();
    }


    public function index()
    {
        return $this->form->grid();
    }

    public function show()
    {
    }

    public function update()
    {
    }
}