<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Category;

use Illuminate\Http\Request;
use Orchid\Platform\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Orchid\Platform\Core\Models\Taxonomy;

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
     * @var null
     */
    protected $behavior;

    /**
     * CategoryDescForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('dashboard::systems/category.display');

        $category = config('platform.common.category');
        $this->behavior = (new $category);
        parent::__construct($request);
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return array_merge([
            'slug' => 'required|max:255|unique:terms,slug,'.$this->request->get('slug').',slug',
        ], $this->behavior->rules());
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
            'locales'      => collect(config('platform.locales')),
            'behavior'       => $this->behavior,
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
