<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\TermTaxonomy;
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
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return $this->form
            ->route('dashboard.tools.category.store')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, TermTaxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        return redirect()->back();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->form->render();
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     *
     * @return mixed
     */
    public function edit(Request $request, TermTaxonomy $termTaxonomy)
    {
        return $this->form
            ->route('dashboard.tools.category.update')
            ->slug($termTaxonomy->id)
            ->method('PUT')
            ->render($termTaxonomy);
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TermTaxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        return redirect()->back();
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, TermTaxonomy $termTaxonomy)
    {
        $this->form->remove($request, $termTaxonomy);

        return redirect()->route('dashboard.tools.category');
    }
}
