<?php

namespace Orchid\Http\Forms\Tools\Category;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Core\Models\TermTaxonomy;
use Orchid\Forms\Form;

class CategoryDescForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Display';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = TermTaxonomy::class;

    /**
     * CategoryDescForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        parent::__construct($request);
        $this->name = trans('dashboard::tools/category.display');
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|max:255|unique:terms,slug,' . $this->request->get('slug') . ',slug',
        ];
    }

    /**
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(TermTaxonomy $termTaxonomy = null): View
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model([
            'id' => 0,
        ]);

        return view('dashboard::container.tools.category.desc', [
            'language'     => App::getLocale(),
            'termTaxonomy' => $termTaxonomy,
            'locales'      => config('content.locales'),
        ]);
    }

    /**
     * @param Request|null      $request
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, TermTaxonomy $termTaxonomy = null)
    {
        if (is_null($termTaxonomy)) {
            $termTaxonomy = new $this->model();
        }

        $termTaxonomy->term->fill($request->all());
        $termTaxonomy->term->save();
    }
}
