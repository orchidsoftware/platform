<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Orchid\Foundation\Events\Tools\CategoryEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class CategoryFormGroup extends FormGroup
{
    /**
     * @var string
     */
    public $view = 'dashboard::container.tools.category.category';

    /**
     * @var
     */
    public $event = CategoryEvent::class;

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
        return view('dashboard::container.systems.categry.grid', [
        ]);
    }
}
