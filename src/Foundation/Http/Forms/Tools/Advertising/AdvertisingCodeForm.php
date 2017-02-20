<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 14:39.
 */

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;

use Illuminate\Http\Request;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class AdvertisingCodeForm extends Form
{
    use CodeOperations;

    /**
     * @var string
     */
    public $name = 'Код';

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
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(TermTaxonomy $termTaxonomy = null)
    {
        return view('dashboard::container.tools.advertising.code');
    }

    /**
     * @param Request|null      $request
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, TermTaxonomy $termTaxonomy = null)
    {
        $totalRequest = $request->all();
        $code = $totalRequest['code'];

        $path = config('ads.path');

        $fullSavePath = $this->createCodePath($path, $code);

        $this->saveCode($code, $fullSavePath);

        Alert::success('success');
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     */
    public function delete(Request $request, TermTaxonomy $termTaxonomy)
    {
    }
}
