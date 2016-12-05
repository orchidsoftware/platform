<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Orchid\Foundation\Events\Tools\CategoryEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class CategoryFormGroup extends FormGroup
{

    /**
     * @var
     */
    public $event = CategoryEvent::class;

    /**
     * @var array
     */
    public $route = [
        'index' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.category',
        ],
        'create' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.category.create',
        ],
        'edit' => [
            'method' => 'GET',
            'name' => 'dashboard.tools.category.edit',
        ],
        'update' => [
            'method' => 'PUT',
            'name' => 'dashboard.tools.category.update',
        ],
        'store' => [
            'method' => 'POST',
            'name' => 'dashboard.tools.category.store',
        ],
        'destroy' => [
            'method' => 'DELETE',
            'name' => 'dashboard.tools.category.destroy',
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
