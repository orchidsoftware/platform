<?php

namespace Orchid\Platform\Http\Screens\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Orchid\Platform\Core\Models\Taxonomy;
use Orchid\Platform\Core\Models\Category;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;

use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

use Orchid\Platform\Http\Layouts\Category\CategoryEditLayout;

class CategoryEdit extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'dashboard::systems/category.title';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'dashboard::systems/category.description';

    /**
     * Query data
     *
     * @param int $categoryId
     *
     * @return array
     */
    public function query($category = null): array
    {
        $category = is_null($category) ? new Category() : $category;
        

        $anycategory= Category::whereNotIn('id', [$category->id])->get();
        
        $catselect[0] = trans('dashboard::systems/category.not_parrent');
        foreach (Category::whereNotIn('id', [$category->id])->get() as $cat) {
            $catselect[$cat->id] = $cat->term->GetContent('name');
        }

        return [
            'category' => $category,
            'catselect'=> $catselect,
        ];

    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('dashboard::common.commands.save'))->icon('icon-check')->method('save'),
            Link::name(trans('dashboard::common.commands.remove'))->icon('icon-trash')->method('remove'),
        ];
    }

    /**
     * Views
     *
     * @return array
     */

    public function layout(): array
    {
        return [
            Layouts::columns([
                'CategoryEdit' => [
                    CategoryEditLayout::class
                ],
            ]),

        ];
    }

    /**
     * @param Category $category
     * @param Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Category $category, Request $request)
    {
        
        $attributes = $request->get('category');
        $locale =App::getLocale();
        $attributes['term']['content'][$locale]=$attributes['content'];
        

        $category->parent_id = $attributes['parent_id'];
       
        $category->term->fill($attributes['term']);  


        $category->save();
        $category->term->save();
        Alert::info(trans('dashboard::systems/category.Category was saved'));

        return redirect()->route('dashboard.systems.category');
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Category $category)
    {

        $category->delete();

        Alert::info(trans('dashboard::systems/category.Category was removed'));

        return redirect()->route('dashboard.systems.category');
    }

}
