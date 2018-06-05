<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Press\Models\Post;
use Orchid\Support\Facades\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\Many as PostBehavior;
use Orchid\Platform\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;

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
        $this->checkPermission('platform.posts');
        $this->locales = collect(config('press.locales'));
    }

    /**
     * @param PostBehavior $type
     *
     * @return View
     */
    public function index(PostBehavior $type) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        return view('platform::container.posts.main', $type->generateGrid());
    }

    /**
     * @param PostBehavior $type
     *
     * @return View
     */
    public function create(PostBehavior $type) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        $locales = (method_exists($type, 'locale')) ? collect($type->locale()) : $this->locales;

        return view('platform::container.posts.create', [
            'type'    => $type,
            'locales' => $locales,
            'post'    => new Post(),
        ]);
    }

    /**
     * @param Request      $request
     * @param Post         $post
     * @param PostBehavior $type
     *
     * @return RedirectResponse
     */
    public function store(Request $request, PostBehavior $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);
        $this->validate($request, $type->rules());

        $post->fill($request->all())->fill([
            'type'       => $type->slug,
            'user_id'    => Auth::user()->id,
            'publish_at' => (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish')),
            'options'    => $post->getOptions(),
        ]);

        if ($request->filled('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $slug = $type->slugFields ? head($content)[$type->slugFields] : 1;
        }

        $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);

        $post->save();

        foreach ($type->getModules() as $module) {
            $module = new $module();
            $module->save($type, $post);
        }

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
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
    public function edit(PostBehavior $type, Post $post) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        $locales = (method_exists($type, 'locale')) ? collect($type->locale()) : $this->locales;

        return view('platform::container.posts.edit', [
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
     * @throws \Throwable|\Orchid\Platform\Exceptions\TypeException
     */
    public function update(Request $request, PostBehavior $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);
        $post->fill($request->except('slug'));
        $post->user_id = Auth::user()->id;

        $post->publish_at = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));
        $post->options = $post->getOptions();

        $slug = null;

        if ($request->filled('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $behaviorObject = $post->getBehaviorObject();
            if (property_exists($behaviorObject, 'slugFields')) {
                $slug = head($content)[$behaviorObject->slugFields];
            }
        }

        if (! empty($slug) && $slug !== $post->slug) {
            $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);
        }

        $post->save();

        foreach ($type->getModules() as $module) {
            $module = new $module();
            $module->save($type, $post);
        }

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param PostBehavior $type
     * @param Post         $post
     *
     * @throws \Exception
     *
     * @return mixed
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(PostBehavior $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        $id = $post->id;
        $post->delete();

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type'    => $type->slug,
        ])->with([
            'restore' => route('platform.posts.restore', $id),
        ]);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     */
    public function restore($id) : RedirectResponse
    {
        $post = Post::onlyTrashed()->find($id);
        $post->restore();

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
       ]);
    }
}
