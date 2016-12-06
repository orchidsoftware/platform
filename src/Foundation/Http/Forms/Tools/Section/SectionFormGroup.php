<?php

namespace Orchid\Foundation\Http\Forms\Tools\Section;

use Orchid\Foundation\Services\Forms\FormGroup;
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
     * LocalizationFormGroup constructor.
     */
    public function __construct()
    {
        $registerForm = event(new $this->event($this));
        $this->group = collect($registerForm);
        $this->storage = collect();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grid()
    {
        dd('grid');

        return view('dashboard::container.tools.category.grid', [
        ]);
    }
}
