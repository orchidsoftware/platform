<?php

namespace Orchid\Foundation\Http\Forms\Tools\Section;

use Orchid\Foundation\Core\Models\Section;
use Orchid\Forms\FormGroup;
use Orchid\Foundation\Events\Tools\SectionEvent;

class SectionFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = SectionEvent::class;

    /**
     * @var array
     */
    public $route = [
        'index' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.section',
        ],
        'create' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.section.create',
        ],
        'edit' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.section.edit',
        ],
        'update' => [
            'method' => 'PUT',
            'name' => 'dashboard.tools.section.update',
        ],
        'store' => [
            'method' => 'POST',
            'name' => 'dashboard.tools.section.store',
        ],
        'destroy' => [
            'method' => 'DELETE',
            'name' => 'dashboard.tools.section.destroy',
        ],
    ];

    /**
     * Description Attributes for group.
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
