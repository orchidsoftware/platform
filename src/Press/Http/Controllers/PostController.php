<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Press\Models\Post;
use Orchid\Press\Entities\Many;
use Orchid\Support\Facades\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Orchid\Platform\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.posts');
    }

    /**
     * @param Many $type
     *
     * @return View
     */
    public function index(Many $type) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        return view('platform::container.posts.main', $type->generateGrid());
    }

    /**
     * @param Many $type
     *
     * @return View
     */
    public function create(Many $type) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        return view('platform::container.posts.create', [
            'type'    => $type,
            'locales' => collect($type->locale()),
            'post'    => $type->create(new Post()),
        ]);
    }

    /**
     * @param Request      $request
     * @param Post         $post
     * @param Many $type
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Many $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);
        $this->validate($request, $type->rules());

        $post->fill($request->all())->fill([
            'type'       => $type->slug,
            'user_id'    => $request->user()->id,
            'publish_at' => (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish')),
            'options'    => $post->getOptions(),
        ]);

        $slug = $request->get('slug');

        if (! $request->filled('slug')) {
            $content = $request->get('content');
            $slug = $type->slugFields ? head($content)[$type->slugFields] : '';
        }

        $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);

        $type->save($post);

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Many $type
     * @param Post         $post
     *
     * @return View
     *
     * @internal param Request $request
     */
    public function edit(Many $type, Post $post) : View
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        return view('platform::container.posts.edit', [
            'type'    => $type,
            'locales' => collect($type->locale()),
            'post'    => $post,
        ]);
    }

    /**
     * @param Request      $request
     * @param Many $type
     * @param Post         $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function update(Request $request, Many $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        $post->fill($request->except('slug'));
        $post->user_id = $request->user()->id;

        $post->publish_at = (is_null($request->get('publish'))) ? null : Carbon::parse($request->get('publish'));
        $post->options = $post->getOptions();

        if ($request->filled('slug')) {
            $slug = $request->get('slug');
        } else {
            $content = $request->get('content');
            $entityObject = $post->getEntityObject();
            if (property_exists($entityObject, 'slugFields')) {
                $slug = head($content)[$entityObject->slugFields] ?? '';
            }
        }

        if (! empty($slug) && $slug !== $post->slug) {
            $post->slug = SlugService::createSlug(Post::class, 'slug', $slug);
        }

        $type->save($post);

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Many $type
     * @param Post         $post
     *
     * @throws \Exception
     *
     * @return RedirectResponse
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(Many $type, Post $post) : RedirectResponse
    {
        $this->checkPermission('platform.posts.type.'.$type->slug);

        $type->delete($post);

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.posts.type', [
            'type'    => $type->slug,
        ])->with([
            'restore' => route('platform.posts.restore', $post->id),
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
