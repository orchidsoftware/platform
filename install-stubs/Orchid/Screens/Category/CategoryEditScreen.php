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

class CategoryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Category';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Category of the website';

    /**
     * Query data.
     *
     * @param Category $category
     *
     * @return array
     */
    public function query(Category $category = null): array
    {
        $category = is_null($category) ? new Category() : $category;
        $catselect[0] = trans('platform::systems/category.not_parrent');
        if ($category->exists) {
            foreach (Category::whereNotIn('id', [$category->id])->get() as $cat) {
                $catselect[$cat->id] = $cat->term->GetContent('name');
            }
            $category['slug'] = $category->term->slug;
        } else {
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
            Link::name(__('Save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(__('Remove'))
                ->icon('icon-trash')
                ->method('remove'),
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
    public function save(Category $category, Request $request)
    {
        $attributes = $request->get('category');

        $locale = App::getLocale();
        $attributes['term']['content'][$locale] = $attributes['content'];
        $attributes['term']['slug'] = $attributes['slug'];
        unset($attributes['slug']);

        if (! $category->exists) {
            $term = Term::firstOrCreate($attributes['term']);
            $category->term_id = $term->id;
            $category->term()->associate($term);
        }

        $category->taxonomy = 'category';
        if ((int) $attributes['parent_id'] > 0) {
            $category->parent_id = (int) $attributes['parent_id'];
        } else {
            $category->parent_id = null;
        }
        $category->term->fill($attributes['term']);

        $category->term->save();
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
