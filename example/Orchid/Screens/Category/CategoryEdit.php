<?php
declare(strict_types=1);
namespace App\Orchid\Screens\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Press\Models\Category;
use Orchid\Support\Facades\Alert;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use Orchid\Screen\Layouts;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
class CategoryEdit extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'platform::systems/category.title';
    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'platform::systems/category.description';
    /**
     * Query data
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
            $anycategory= Category::whereNotIn('id', [$category->id])->get();
            foreach (Category::whereNotIn('id', [$category->id])->get() as $cat) {
                $catselect[$cat->id] = $cat->term->GetContent('name');
            }
        } else {
            $anycategory= Category::get();
            //if ($anycategory->count()) {
                foreach (Category::get() as $cat) {
                    $catselect[$cat->id] = $cat->term->GetContent('name');
                }
            //}
        }
        //dd($category->exists);
        //dd(Category::whereNotIn('id', [$category->id]));
        //dd($category);
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
            Link::name(trans('platform::common.commands.save'))->icon('icon-check')->method('save'),
            Link::name(trans('platform::common.commands.remove'))->icon('icon-trash')->method('remove'),
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