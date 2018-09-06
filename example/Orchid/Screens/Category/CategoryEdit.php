<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Orchid\Press\Models\Term;
use Orchid\Press\Models\Category;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\App;
use App\Orchid\Layouts\Category\CategoryEditLayout;

class CategoryEdit extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/category.title';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/category.description';

    /**
     * Query data.
     *
     * @param int $categoryId
     *
     * @return array
     */
    public function query($id = null): array
    {
        //$category = is_null($category) ? new Category() : $category;
        $category = Category::findOrNew($id);
        $catselect[0] = trans('platform::systems/category.not_parrent');
        if ($category->exists) {
            //$anycategory = Category::whereNotIn('id', [$category->id])->get();
            foreach (Category::whereNotIn('id', [$category->id])->get() as $cat) {
                $catselect[$cat->id] = $cat->term->GetContent('name');
            }
            $category['slug'] = $category->term->slug;
        } else {
            //$anycategory = Category::get();
            foreach (Category::get() as $cat) {
                $catselect[$cat->id] = $cat->term->GetContent('name');
            }
        }

        return [
            'category' => $category,
            'catselect'=> $catselect,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('platform::common.commands.save'))->icon('icon-check')->method('save'),
            Link::name(trans('platform::common.commands.remove'))->icon('icon-trash')->method('remove'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::columns([
                'CategoryEdit' => [
                    CategoryEditLayout::class,
                ],
            ]),
        ];
    }

    /**
     * @param Category $category
     * @param Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($id, Request $request)
    {
        $category = Category::findOrNew($id);
        $attributes = $request->get('category');

        $locale = App::getLocale();
        $attributes['term']['content'][$locale] = $attributes['content'];
        $attributes['term']['slug'] = $attributes['slug'];
        unset($attributes['slug']);

        //if ((int)$attributes['parent_id']>0) {
        //}
        $category->parent_id = (int) $attributes['parent_id'];
        $category->taxonomy = 'category';

        if (is_null($id)) {
            $term = Term::firstOrCreate(['slug' => $attributes['term']['slug']]);
            $term->fill($attributes['term']);
            $term->save();
            $category->term_id = $term->id;
        } else {
            $category->term->fill($attributes['term']);
            $category->term->save();
        }

        $category->term($term);
        $category->save();

        Alert::info(trans('platform::systems/category.Category was saved'));

        return redirect()->route('platform.systems.category');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Category $category)
    {
        $category->delete();
        Alert::info(trans('platform::systems/category.Category was removed'));

        return redirect()->route('platform.systems.category');
    }
}
