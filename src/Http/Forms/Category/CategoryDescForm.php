<?php

namespace Orchid\Platform\Http\Forms\Category;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Taxonomy;
use Orchid\Platform\Forms\Form;

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
    protected $model = Taxonomy::class;

    /**
     * CategoryDescForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::systems/category.display');
        parent::__construct($request);
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            'slug' => 'required|max:255|unique:terms,slug,' . $this->request->get('slug') . ',slug',
        ];
    }

    /**
     * @param Taxonomy|null $termTaxonomy
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(Taxonomy $termTaxonomy = null) : View
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model([
            'id' => 0,
        ]);

        return view('dashboard::container.systems.category.desc', [
            'language'     => App::getLocale(),
            'termTaxonomy' => $termTaxonomy,
            'locales'      => config('platform.locales'),
        ]);
    }

    /**
     * @param Request|null  $request
     * @param Taxonomy|null $termTaxonomy
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, Taxonomy $termTaxonomy = null)
    {
        if (is_null($termTaxonomy)) {
            $termTaxonomy = new $this->model();
        }

        $termTaxonomy->term->fill($request->all());
        $termTaxonomy->term->save();
    }
}
