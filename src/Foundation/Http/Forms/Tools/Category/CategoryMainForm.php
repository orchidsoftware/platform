<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Section;
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
    protected $model = Category::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|unique:sections,slug,'.$this->request->get('slug').',slug',
        ];
    }


    /**
     * @param TermTaxonomy|null $termTaxonomy
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(TermTaxonomy $termTaxonomy = null)
    {
        $termTaxonomy = $termTaxonomy ?: new $this->model();
        $category = Category::get();
        $language = App::getLocale();

        return view('dashboard::container.tools.category.info', [
            'category' => $category,
            'language' => $language,
            'termTaxonomy'  => $termTaxonomy,
            'locales'  => config('content.locales'),
        ]);
    }

    public function persist($storage = null)
    {
        $section = Section::firstOrNew([
            'slug' => $this->request->get('slug'),
        ]);
        $section->fill($this->request->all());

        if (empty($section->section_id)) {
            $section->section_id = null;
        }

        $section->save();

        Alert::success('success');
    }
}
