<?php

namespace Orchid\Http\Controllers\Posts;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Alert\Facades\Alert;
use Orchid\Core\Models\Post;
use Orchid\Http\Controllers\Controller;

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
        $this->checkPermission('dashboard.posts');
        $this->locales = collect(config('content.locales'));
    }

    /**
     * @param Post $post
     *
     * @return View
     */
    public function index(Post $post): View
    {
        return view('dashboard::container.posts.main', $post->getTypeObject()->generateGrid());
    }

    /**
     * @param $post
     *
     * @return View
     */
    public function create($post): View
    {
        $type = $post->getTypeObject();

        return view('dashboard::container.posts.create', [
            'type'    => $type,
            'locales' => $this->locales->where('required', true),
        ]);
    }

    /**
     * @param Request $request
     * @param Post    $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $this->validate($request, $post->getTypeObject()->rules());

        $post->fill($request->all());

        $post->type = $post->getTypeObject()->slug;
        $post->user_id = Auth::user()->id;
        $post->publish_at = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));

        if ($request->has('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $slug = reset($content)[$post->getTypeObject()->slugFields];
        }

        $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);

        //$post->slug = $post->makeSlug($slug);

        $post->save();

        $modules = $post->getTypeObject()->getModules();

        foreach ($modules as $module) {
            $module = new $module();
            $module->save($post->getTypeObject(), $post);
        }

        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Post $type
     * @param Post $post
     *
     * @return View
     *
     * @internal param Request $request
     */
    public function edit(Post $type, Post $post): View
    {
        $type = $type->getTypeObject();

        $locales = $this->locales->map(function ($value, $key) use ($post) {
            $value['required'] = (bool) $post->checkLanguage($key);

            return $value;
        })->where('required', true);

        return view('dashboard::container.posts.edit', [
            'type'    => $type,
            'locales' => $locales,
            'post'    => $post,
        ]);
    }

    /**
     * @param Request $request
     * @param Post    $type
     * @param Post    $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $type, Post $post): RedirectResponse
    {
        $post->fill($request->except('slug'));
        $post->user_id = Auth::user()->id;

        $post->publish_at = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));

        if ($request->has('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $slug = reset($content)[$post->getTypeObject()->slugFields];
        }

        if ($request->has('slug') && $request->get('slug') !== $post->slug) {
            //$post->slug = $post->makeSlug($slug);

            $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);
        }

        $post->save();

        $modules = $type->getTypeObject()->getModules();

        foreach ($modules as $module) {
            $module = new $module();
            $module->save($type->getTypeObject(), $post);
        }

        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Post $type
     * @param Post $post
     *
     * @return mixed
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(Post $type, Post $post): RedirectResponse
    {
        $post->delete();
        Alert::success('Message');

        return redirect()->route('dashboard.posts.type', [
            'type' => $type->getTypeObject()->slug,
        ]);
    }
}
