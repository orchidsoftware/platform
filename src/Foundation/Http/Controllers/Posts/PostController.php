<?php

namespace Orchid\Foundation\Http\Controllers\Posts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Facades\Alert;
use Orchid\Foundation\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * @var
     */
    public $locales;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->locales = config('content.locales');
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Post $post)
    {
        return view('dashboard::container.posts.main', $post->getTypeObject()->generateGrid());
    }

    /**
     * @param $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($post)
    {
        $type = $post->getTypeObject();

        return view('dashboard::container.posts.create', [
            'type' => $type,
            'locales' => $this->locales,
        ]);
    }

    public function show($test = null, $test2 = null)
    {
        dd($test, $test2);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request, Post $post)
    {
        $this->validate($request, $post->getTypeObject()->rules());

        $post->fill($request->all());
        $post->type = $post->getTypeObject()->slug;
        $post->user_id = Auth::user()->id;
        $post->slug = Str::slug($request->get('content')[config('app.locale')][$post->getTypeObject()->slugFields]);
        $post->publish = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));


        $Slugs = $post->where('slug', $post->slug)->count();
        if ($Slugs != 0) {
            $post->slug = $post->slug.'-'.($Slugs + 1);
        }
        $post->save();


        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Request $request
     * @param Post $type
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Post $type, Post $post)
    {
        $type = $type->getTypeObject();

        return view('dashboard::container.posts.edit', [
            'type' => $type,
            'locales' => $this->locales,
            'post' => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Post $type
     * @param Post $post
     */
    public function update(Request $request, Post $type, Post $post)
    {
        $post->fill($request->all());
        $post->user_id = Auth::user()->id;

        $post->slug = Str::slug($request->get('content')[config('app.locale')][$type->getTypeObject()->slugFields]);
        $post->publish = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));



        $Slugs = $post
            ->where('id', '!=', $post->id)
            ->where('slug', $post->slug)
            ->count();

        if ($Slugs > 0) {
            $post->slug = $post->slug.'-'.($Slugs + 1);
        }

        $post->save();

        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Request $request
     * @param Post $type
     * @param Post $post
     * @return mixed
     */
    public function destroy(Request $request, Post $type, Post $post)
    {
        $post->delete();
        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->slug,
        ]);
    }
}
