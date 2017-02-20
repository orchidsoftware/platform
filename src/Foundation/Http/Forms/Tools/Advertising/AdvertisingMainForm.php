<?php

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;

use Illuminate\Http\Request;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class AdvertisingMainForm extends Form
{
    use CodeOperations;

    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Adv::class;

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
        $adsCategory = collect(config('ads.category'));
        $weekDays = collect(config('ads.days'));

        return view('dashboard::container.tools.advertising.info', [
            'categories' => $adsCategory,
            'weekDays'   => $weekDays,
        ]);
    }

    /**
     * @param Request|null      $request
     * @param TermTaxonomy|null $termTaxonomy
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, TermTaxonomy $termTaxonomy = null)
    {
        $requestContent = $request->all();

        $code = $requestContent['code'];
        $path = config('ads.path');

        $fullSavePath = $this->createCodePath($path, $code);

        unset($requestContent['_token']);
        unset($requestContent['_method']);

        $advRecord = Adv::create([
            'content'   => $requestContent,
            'file_name' => $fullSavePath,
        ]);

        $advRecord->save();

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
