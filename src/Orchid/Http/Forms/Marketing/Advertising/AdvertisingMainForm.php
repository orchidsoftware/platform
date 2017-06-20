<?php

namespace Orchid\Http\Forms\Marketing\Advertising;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Core\Models\Post;
use Orchid\Forms\Form;

class AdvertisingMainForm extends Form
{
    /**
     * @var string
     */
    public $name = 'Information';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Post::class;


    /**
     * AdvertisingMainForm constructor.
     *
     * @param null $request
     */
    public function __construct($request = null)
    {
        parent::__construct($request);
        $this->name = trans('dashboard::marketing/advertising.information');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function get(Post $post = null): View
    {
        if (is_null($post)) {
            $post = new Post();
        }
        $adsCategory = collect(config('content.advertising'));

        return view('dashboard::container.marketing.advertising.info', [
            'adv'        => $post,
            'categories' => $adsCategory,
        ]);
    }

    /**
     * @param Request|null $request
     * @param Post|null    $post
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, Post $post = null)
    {
        $parameters = $request->all();

        $parameters['type'] = 'advertising';
        $parameters['options']['startDate'] = Carbon::parse($parameters['options']['startDate'])->timestamp;
        $parameters['options']['endDate'] = Carbon::parse($parameters['options']['endDate'])->timestamp;
        $parameters['user_id'] = Auth::user()->id;

        if (is_null($post)) {
            Post::created([$parameters]);
        } else {
            $post->fill($parameters);
            $post->save();
        }
    }

    /**
     * @param Request|null $request
     * @param Post|null    $post
     */
    public function delete(Request $request = null, Post $post = null)
    {
        $post->delete();
    }
}
