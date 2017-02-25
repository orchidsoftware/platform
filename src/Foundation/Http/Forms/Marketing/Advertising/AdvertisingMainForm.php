<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Advertising;

use Illuminate\Http\Request;

use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class AdvertisingMainForm extends Form
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
     * @param $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(Post $post = null)
    {
        if (is_null($post)) {
            $post = new Post();
        }
        $adsCategory = collect(config('ads.category'));

        return view('dashboard::container.marketing.advertising.info', [
            'adv'       => $post,
            'categories' => $adsCategory,
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
