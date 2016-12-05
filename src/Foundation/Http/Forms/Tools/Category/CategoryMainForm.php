<?php

namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Illuminate\Http\Request;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Services\Forms\Form;
use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Language;

class CategoryMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Category::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:language,name,'.$this->request->get('name').',name',
            'code' => 'required|max:255|unique:language,code,'.$this->request->get('code').',code',
        ];
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $categories = $this->model->get();

        return view('dashboard::container.tools.category.info', [
            'categories' => $categories,
            'locales' => config('content.locales'),
        ]);
    }

    public function create()
    {
        dd('test2');
    }

    public function persist($storage = null)
    {
        Alert::success('Локаль создана');
    }
}
