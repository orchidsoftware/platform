<?php

namespace Orchid\Foundation\Http\Forms\Tools\Section;

use App;
use Illuminate\Http\Request;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Services\Forms\Form;

class SectionMainForm extends Form
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
    protected $model = Section::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|unique:sections,slug,'.$this->request->get('slug').',slug'
        ];
    }


    /**
     * @param null $storage
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($storage = null, $id = null)
    {
        $section = $storage->get('model') ?: new $this->model;

        $sections = $this->model->where('id','!=',$section->id)->get();
        $language = App::getLocale();
        return view('dashboard::container.tools.section.info', [
            'sections' => $sections,
            'language' => $language,
            'section' => $section,
            'locales' => config('content.locales'),
        ]);
    }


    public function persist($storage = null)
    {
        $section = Section::firstOrNew([
            'slug' => $this->request->get('slug'),
        ]);
        $section->fill($this->request->all());

        if(empty($section->section_id)){
            $section->section_id = null;
        }

        $section->save();

        Alert::success('success');
    }
}
