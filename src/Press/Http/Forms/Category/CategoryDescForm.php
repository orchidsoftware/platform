<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Category;

use Orchid\Forms\Form;
use Illuminate\Http\Request;
use Orchid\Press\Models\Taxonomy;
use Illuminate\Contracts\View\View;

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
    protected $entity;

    /**
     * CategoryDescForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        $this->name = trans('platform::systems/category.display');

        $category = config('press.category');
        $this->entity = (new $category());
        parent::__construct($request);
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return array_merge([
            'slug' => 'required|max:255|unique:terms,slug,'.$this->request->get('slug').',slug',
        ], $this->entity->rules());
    }

    /**
     * @param Taxonomy|null $termTaxonomy
     *
     * @return View
     */
    public function get(Taxonomy $termTaxonomy = null) : View
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model([
            'id' => 0,
        ]);

        return view('platform::container.systems.category.desc', [
            'language'       => app()->getLocale(),
            'termTaxonomy'   => $termTaxonomy,
            'locales'        => collect(config('press.locales')),
            'entity'       => $this->entity,
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
