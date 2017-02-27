<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Advertising;

use Illuminate\Support\Facades\App;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\Post;

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
        if(is_null($adv)){
            $adv = new Post();
        }

        $config = collect(config('content'));

        return view('dashboard::container.marketing.advertising.code', [
            'adv'           => $adv,
            'categories'    => $config->get('advertising', []),
            'language'      => App::getLocale(),
            'locales'       => $config->get('locales', []),
        ]);
    }
}
