<?php

namespace Orchid\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Alert\Facades\Alert;
use Orchid\Core\Models\TermTaxonomy;
use Orchid\Http\Controllers\Controller;
use Orchid\Http\Forms\Tools\Category\CategoryFormGroup;

class CategoryController extends Controller
{
    /**
     * @var CategoryFormGroup
     */
    public $form;

    /**
     * CategoryController constructor.
     *
     * @param CategoryFormGroup $form
     */
    public function __construct(CategoryFormGroup $form)
    {
        $this->checkPermission('dashboard.tools.category');
        $this->form = $form;
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

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->form->render();
    }

    /**
     * @param TermTaxonomy $termTaxonomy
     *
     * @return mixed
     *
     * @internal param Request $request
     */
    public function edit(TermTaxonomy $termTaxonomy)
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

        Alert::success(trans('dashboard::common.alert.success'));

        return back();
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

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.tools.category');
    }
}
