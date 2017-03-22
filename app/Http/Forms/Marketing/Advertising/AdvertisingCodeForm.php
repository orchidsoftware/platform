<?php

namespace Orchid\Http\Forms\Marketing\Advertising;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Orchid\Core\Models\Post;
use Orchid\Forms\Form;

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
     * @param Post $adv
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     * @internal param $item
     */
    public function get(Post $adv = null) : View
    {
        if (is_null($adv)) {
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
