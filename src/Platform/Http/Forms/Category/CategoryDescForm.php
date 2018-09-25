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
        $this->behavior = (new $category());
        parent::__construct($request);
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return $this->behavior->rules();
    }

    public function validationCustomAttributes() : array
    {
        return [
            'content.*.name' => trans('dashboard::systems/category.fields.name_title'),
            'content.*.body' => trans('dashboard::systems/category.fields.body_title'),
            'slug' => trans('dashboard::systems/category.slug'),
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
            'language'       => App::getLocale(),
            'termTaxonomy'   => $termTaxonomy,
            'locales'        => collect(config('platform.locales')),
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

        $data = $request->all();
        $data['slug'] = str_slug($data['slug']);

        $termTaxonomy->term->fill($data);
        $termTaxonomy->term->save();
    }
}
