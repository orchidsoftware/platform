<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Category;

use Illuminate\View\View;
use Orchid\Press\Models\Category;
use Orchid\Forms\FormGroup;
use Orchid\Platform\Events\CategoryEvent;

class CategoryFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = CategoryEvent::class;

    /**
     * @var
     */
    protected $categoryBehavior;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('platform::systems/category.title'),
            'description' => trans('platform::systems/category.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main(): View
    {
        $entity = config('press.category');
        $entity = new $entity();

        return view('platform::container.systems.category.grid', [
            'category' => Category::where('parent_id', 0)->with('allChildrenTerm')->paginate(),
            'entity' => $entity,
            'filters'  => collect($entity->filters()),
            'chunk'    => $entity->chunk,
        ]);
    }
}
