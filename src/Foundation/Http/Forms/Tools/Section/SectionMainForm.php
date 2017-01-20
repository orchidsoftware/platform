<?php

namespace Orchid\Foundation\Http\Forms\Tools\Section;

use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Facades\Alert;

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
            'slug' => 'required|max:255|unique:sections,slug,'.$this->request->get('slug').',slug',
        ];
    }

    /**
     * @param Section|null $section
     *
     * @return mixed
     */
    public function get(Section $section = null)
    {
        $section = $section ?: new $this->model();

        $sections = $this->model->where('id', '!=', $section->id)->get();
        $language = App::getLocale();

        return view('dashboard::container.tools.section.info', [
            'sections' => $sections,
            'language' => $language,
            'section'  => $section,
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
