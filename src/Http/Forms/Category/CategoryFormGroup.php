<?php

namespace Orchid\Platform\Http\Forms\Category;

use Illuminate\View\View;
use Orchid\Platform\Core\Models\Category;
use Orchid\Platform\Events\CategoryEvent;
use Orchid\Platform\Forms\FormGroup;

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
            'name'        => trans('dashboard::systems/category.title'),
            'description' => trans('dashboard::systems/category.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main() : View
    {
        return view('dashboard::container.systems.category.grid', [
            'category' => Category::where('parent_id', 0)->with('allChildrenTerm')->paginate(),
        ]);
    }
}
