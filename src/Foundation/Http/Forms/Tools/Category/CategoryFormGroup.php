<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Section;
use Orchid\Foundation\Events\Tools\CategoryEvent;

class CategoryFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = CategoryEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        => 'Разделы',
            'description' => 'Разделы веб-сайта',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        return view('dashboard::container.tools.category.grid', [
            'category' => Category::where('parent_id',0)->with('allChildrenTerm')->paginate()
        ]);
    }
}
