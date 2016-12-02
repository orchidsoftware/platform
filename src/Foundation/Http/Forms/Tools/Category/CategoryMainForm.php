<?php
namespace Orchid\Foundation\Http\Forms\Tools\Category;

use Orchid\Foundation\Core\Models\Category;
use Orchid\Foundation\Core\Models\Language;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Services\Forms\Form;

class CategoryMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Main';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Category::class;

    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:language,name,' . $this->request->get('name') . ',name',
            'code' => 'required|max:255|unique:language,code,' . $this->request->get('code') . ',code',
        ];
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return view('dashboard::container.tools.category.info', []);;
    }

    public function persist($storage = null)
    {

        Alert::success('Локаль создана');
    }
}
