<?php

namespace Orchid\Foundation\Http\Forms\Tools\Section;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Events\Tools\SectionEvent;

class SectionFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = SectionEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Разделы',
            'description' => 'Разделы веб-сайта',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        return view('dashboard::container.tools.section.grid', [
            'sections' => Section::paginate(),
        ]);
    }
}
