<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 14:39
 */

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;


use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\Term;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Category;

class AdvertisingPreviewForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Предпросмотр';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = TermTaxonomy::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => 'required|max:255|unique:terms,slug,'.$this->request->get('slug').',slug',
        ];
    }

    /**
     * @param $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($item = null)
    {
        return view('dashboard::container.tools.advertising.preview');
    }

    /**
     * @param Request|null $request
     * @param Adv|null $adv
     * @return mixed|void
     */
    public function persist(Request $request = null, $adv = null)
    {
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     */
    public function delete(Request $request, TermTaxonomy $termTaxonomy)
    {
    }
}