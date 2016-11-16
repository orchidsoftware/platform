<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.11.16
 * Time: 11:18.
 */
namespace Orchid\Foundation\Http\Forms\Systems\Localization;

use Orchid\Foundation\Core\Models\Language;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Services\Forms\Form;

class LocalizationMainForm extends Form
{
    public $name = 'Main';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Language::class;

    public function rules()
    {
        return [
            'name'        => 'required|max:255|unique:language,name,'.$this->request->get('name').',name',
            'code'        => 'required|max:255|unique:language,code,'.$this->request->get('code').',code',
        ];
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $rendered_view = view('dashboard::container.systems.localization.info', []);

        return $rendered_view;
    }

    public function persist($storage = null)
    {
        $locale = Language::firstOrNew([
            'code' => $this->request->get('code'),
        ]);
        $locale->fill($this->request->all());

        $locale->save();

        Alert::success('Локаль создана');
    }
}
