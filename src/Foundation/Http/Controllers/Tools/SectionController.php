<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Tools\Section\SectionFormGroup;

class SectionController extends Controller
{
    /**
     * @var
     */
    public $form = SectionFormGroup::class;

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
    public function create()
    {
        return $this->form
            ->route('dashboard.tools.section.store')
            ->method('POST')
            ->render();
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
    public function get()
    {
        return $this->form->render();
    }

    /**
     * @param Section $section
     *
     * @return mixed
     */
    public function edit(Section $section)
    {
        return $this->form
            ->route('dashboard.tools.section.update')
            ->method('PUT')
            ->render($section);
    }

    /**
     * @param Request $request
     * @param Section $section
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Section $section)
    {
        $this->form->save($request, $section);

        return redirect()->back();
    }

    /**
     * @return mixed
     */
    public function store()
    {
        $this->form->save();

        return redirect()->back();
    }
}
