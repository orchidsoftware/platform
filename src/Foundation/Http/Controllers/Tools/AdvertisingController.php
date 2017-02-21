<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 10:41.
 */

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Adv;
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

    public function update(Request $request, Adv $item)
    {
        $this->form->save($request, $item);

        return redirect()->back();
    }

    public function edit($item_id)
    {
        $item = Adv::where('id', $item_id)->first();

        return $this->form
            ->route('dashboard.tools.advertising.update')
            ->slug($item_id)
            ->method('PUT')
            ->render($item);
    }

    public function store(Request $request, TermTaxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        return redirect()->back();
    }
}
