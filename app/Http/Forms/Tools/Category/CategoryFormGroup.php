<?php

namespace Orchid\Http\Forms\Tools\Category;

use Illuminate\View\View;
use Orchid\Forms\FormGroup;
use Orchid\Core\Models\Category;
use Orchid\Events\Tools\CategoryEvent;

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
    public function attributes() : array
    {
        return [
            'name'        => 'Разделы',
            'description' => 'Разделы веб-сайта',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main() : View
    {
        return view('dashboard::container.tools.category.grid', [
            'category' => Category::where('parent_id', 0)->with('allChildrenTerm')->paginate(),
        ]);
    }
}
