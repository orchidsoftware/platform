<?php

namespace Orchid\Http\Controllers\Posts;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Alert\Facades\Alert;
use Orchid\Behaviors\Many as PostBehavior;
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
     * @param PostBehavior $type
     *
     * @return View
     */
    public function index(PostBehavior $type): View
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);

        return view('dashboard::container.posts.main', $type->generateGrid());
    }

    /**
     * @param PostBehavior $type
     *
     * @return View
     */
    public function create(PostBehavior $type): View
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);

        return view('dashboard::container.posts.create', [
            'type'    => $type,
            'locales' => $this->locales->where('required', true),
        ]);
    }

    /**
     * @param Request      $request
     * @param Post         $post
     * @param PostBehavior $type
     *
     * @return RedirectResponse
     */
    public function store(Request $request, PostBehavior $type, Post $post): RedirectResponse
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);
        $this->validate($request, $type->rules());

        $post->fill($request->all());

        $post->fill([
            'type'       => $type->slug,
            'user_id'    => Auth::user()->id,
            'publish_at' => (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish')),
            'options'    => $post->getOptions(),
        ]);


        if ($request->has('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $slug = reset($content)[$type->slugFields];
        }

        $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);

        $post->save();

        $modules = $type->getModules();

        foreach ($modules as $module) {
            $module = new $module();
            $module->save($type, $post);
        }

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param PostBehavior $type
     * @param Post         $post
     *
     * @return View
     *
     * @internal param Request $request
     */
    public function edit(PostBehavior $type, Post $post): View
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);
        $locales = $this->locales->map(function ($value, $key) use ($post) {
            $value['required'] = (bool)$post->checkLanguage($key);

            return $value;
        })->where('required', true);

        return view('dashboard::container.posts.edit', [
            'type'    => $type,
            'locales' => $locales,
            'post'    => $post,
        ]);
    }

    /**
     * @param Request      $request
     * @param PostBehavior $type
     * @param Post         $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PostBehavior $type, Post $post): RedirectResponse
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);
        $post->fill($request->except('slug'));
        $post->user_id = Auth::user()->id;

        $post->publish_at = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));
        $post->options = $post->getOptions();


        if ($request->has('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $slug = reset($content)[$post->getBehaviorObject()->slugFields];
        }

        if ($request->has('slug') && $request->get('slug') !== $post->slug) {
            $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);
        }

        $post->save();

        $modules = $type->getModules();

        foreach ($modules as $module) {
            $module = new $module();
            $module->save($type, $post);
        }

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param PostBehavior $type
     * @param Post         $post
     *
     * @return mixed
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(PostBehavior $type, Post $post): RedirectResponse
    {
        $this->checkPermission('dashboard.posts.' . $type->slug);
        $post->delete();
        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.posts.type', [
            'type' => $type->slug,
        ]);
    }
}
