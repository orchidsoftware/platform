<?php

namespace Orchid\Platform\Http\Screens\Category;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

use Orchid\Platform\Core\Models\Taxonomy;
use Orchid\Platform\Core\Models\Category;

use Orchid\Platform\Http\Layouts\Category\CategoryListLayout;

class CategoryList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'dashboard::systems/category.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'dashboard::systems/category.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
       
        return [
            'category' => Category::paginate(),

        ];

    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
            Link::name(' '.trans('dashboard::common.Create'))->icon('icon-plus')->method('create'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout() : array
    {
        return [
            CategoryListLayout::class,
        ];
    }

    /**
     * @param Request $request
     *
     * @return null
     */
    public function create()
    {
        return redirect()->route('dashboard.systems.category.create');
    }
}
