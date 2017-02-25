<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Advertising;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class AdvertisingCodeForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Код';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Post::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @param Post $adv
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @internal param $item
     */
    public function get(Post $adv = null)
    {
        $config = collect(config('content'));

        return view('dashboard::container.marketing.advertising.code', [
            'adv'           => $adv,
            'categories'    => $config->get('advertising',[]),
            'language'      => App::getLocale(),
            'locales'       => $config->get('locales',[]),
        ]);
    }

    /**
     * @param Request|null $request
     * @param null         $adv
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, $adv = null)
    {
        $requestContent = $request->all();

        $code = $requestContent['code'];

        $fullSavePath = $this->createDbPath($code);

        unset($requestContent['_token']);
        unset($requestContent['_method']);
        unset($requestContent['code']);
        if (!($adv instanceof Adv)) {
            $adv = Adv::create([
                'content'   => $requestContent,
                'file_name' => $fullSavePath,
            ]);
        } else {
            $segments = $request->segments();
            $item_id = $segments[count($segments) - 1];

            $adv = Adv::where('id', $item_id)->first();

            $adv->content = $requestContent;
            $adv->file_name = $fullSavePath;
        }

        $adv->save();

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
