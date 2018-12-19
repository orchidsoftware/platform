<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Press\Models\Category;
use App\Orchid\Layouts\Category\CategoryListLayout;

class CategoryListScreen extends Screen
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
     * @return array
     */
    public function query() : array
    {
        $categories = Category::where('parent_id', null)->with('allChildrenTerm')->get();
        $allCategories = collect();

        foreach ($categories as $category) {
            $allCategories = $allCategories->merge($this->getCategory($category));
        }

        return [
            'category' => $allCategories,
        ];
    }

    /**
     * @param \Orchid\Press\Models\Category $category
     * @param string                        $delimiter
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCategory(Category $category, $delimiter = '')
    {
        $result = collect();
        $category->delimiter = $delimiter;
        $result->push($category);

        if (! $category->allChildrenTerm()->count()) {
            return $result;
        }

        foreach ($category->allChildrenTerm()->get() as $item) {
            $result = $result->merge($this->getCategory($item, $delimiter.'-'));
        }

        return $result;
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
            Link::name(__('Add'))
                ->icon('icon-plus')
                ->link(route('platform.systems.category.create')),
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
}
