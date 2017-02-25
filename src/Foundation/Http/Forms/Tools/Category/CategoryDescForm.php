<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Term;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class CategoryDescForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Информация';

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

        return view('dashboard::container.tools.category.desc', [
            'language'      => App::getLocale(),
            'termTaxonomy'  => $termTaxonomy,
            'locales'       => config('content.locales'),
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

        Alert::success('success');
    }
}
