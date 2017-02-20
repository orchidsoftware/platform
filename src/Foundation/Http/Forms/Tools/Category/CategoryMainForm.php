<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Term;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class CategoryMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = TermTaxonomy::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|unique:terms,slug,'.$this->request->get('slug').',slug',
        ];
    }

    /**
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(TermTaxonomy $termTaxonomy = null)
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model([
            'id' => 0,
        ]);
        $category = Category::where('id', '!=', $termTaxonomy->id)->get();

        $language = App::getLocale();

        return view('dashboard::container.tools.category.info', [
            'category'      => $category,
            'language'      => $language,
            'termTaxonomy'  => $termTaxonomy,
            'locales'       => config('content.locales'),
        ]);
    }

    /**
     * @param Request|null $request
     * @param TermTaxonomy|null $termTaxonomy
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

        Alert::success('success');
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     */
    public function delete(Request $request, TermTaxonomy $termTaxonomy)
    {
        $termTaxonomy->term->delete();
        $termTaxonomy->delete();
        Alert::success('success');
    }
}
