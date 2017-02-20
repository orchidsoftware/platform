<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 10:41.
 */

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Tools\Advertising\AdvertisingFormGroup;

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

    public function create()
    {
        $formView = $this->form
            ->route('dashboard.tools.advertising.store')
            ->method('POST')
            ->render();

        return $formView;
    }

    public function update()
    {
    }

    public function store(Request $request, TermTaxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        return redirect()->back();
    }
}
