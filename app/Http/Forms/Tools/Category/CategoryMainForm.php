<?php

namespace Orchid\Http\Forms\Tools\Category;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Orchid\Core\Models\Category;
use Orchid\Core\Models\Term;
use Orchid\Core\Models\TermTaxonomy;
use Orchid\Forms\Form;

class CategoryMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

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
        $this->name = trans('dashboard::tools/category.information');
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
        $category = Category::where('id', '!=', $termTaxonomy->id)->get();

        return view('dashboard::container.tools.category.info', [
            'category'     => $category,
            'termTaxonomy' => $termTaxonomy,
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

        if ($request->get('term_id') == 0) {
            $term = Term::create($request->all());
        } else {
            $term = Term::find($request->get('term_id'));
        }

        $termTaxonomy->fill($this->request->all());
        $termTaxonomy->term_id = $term->id;

        $termTaxonomy->save();
        $term->save();
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     */
    public function delete(Request $request, TermTaxonomy $termTaxonomy)
    {
        $termTaxonomy->term->delete();
        $termTaxonomy->delete();
    }
}
