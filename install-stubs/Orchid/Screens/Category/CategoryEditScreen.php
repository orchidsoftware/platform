<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Press\Models\Term;
use Orchid\Press\Models\Category;
use Orchid\Support\Facades\Alert;
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
        if (! $category->exists) {
            $category->setRelation('term', [new Term()]);
        }

        return [
            'category' => $category,
            'catselect'=> $category->getAllCategories(),
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
            CategoryEditLayout::class,
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

        if (! $category->exists) {
            $category->newWithCreateTerm($attributes['term']);
        }

        $category->setParent($attributes['parent_id']);

        $category->term->fill($attributes['term'])->save();
        $category->save();

        Alert::info(__('Category was saved'));

        return redirect()->route('platform.systems.category');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Category $category)
    {
        $category->term->delete();
        $category->delete();

        Alert::info(__('Category was removed'));

        return redirect()->route('platform.systems.category');
    }
}
