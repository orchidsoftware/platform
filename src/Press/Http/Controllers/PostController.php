<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Press\Models\Post;
use Orchid\Press\Entities\Many;
use Orchid\Support\Facades\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\EntityContract;
use Orchid\Platform\Http\Controllers\Controller;

class PostController extends Controller
{
    public const POST_PERMISSION_PREFIX = 'platform.posts.type.';

    /**
     * @param Many $type
     *
     * @return View
     */
    public function index(Many $type): View
    {
        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);

        return view('platform::container.posts.main', $type->generateGrid());
    }

    /**
     * @param EntityContract $type
     *
     * @return View
     */
    public function create(EntityContract $type): View
    {
        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);

        return view('platform::container.posts.create', [
            'type'    => $type,
            'locales' => collect($type->locale()),
            'post'    => $type->create(new Post),
        ]);
    }

    /**
     * @param Request $request
     * @param EntityContract $type
     * @param Post $post
     *
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, EntityContract $type, Post $post): RedirectResponse
    {
        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);
        $type->isValid();

        $post->fill($request->all())->fill([
            'type'    => $type->slug,
            'user_id' => $request->user()->id,
            'options' => $post->getOptions(),
        ]);

        $type->save($post);

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }

    /**
     * @param Many $type
     * @param Post $post
     *
     * @return View
     *
     * @internal param Request $request
     */
    public function edit(Many $type, Post $post): View
    {
        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);

        return view('platform::container.posts.edit', [
            'type'    => $type,
            'locales' => collect($type->locale()),
            'post'    => $type->create($post),
        ]);
    }

    /**
     * @param Request $request
     * @param EntityContract $type
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable|\Orchid\Press\Exceptions\EntityTypeException
     */
    public function update(Request $request, EntityContract $type, Post $post): RedirectResponse
    {
        return $this->store($request, $type, $post);
    }

    /**
     * @param EntityContract $type
     * @param Post $post
     *
     * @throws \Exception
     *
     * @return RedirectResponse
     *
     * @internal param Request $request
     * @internal param Post $type
     */
    public function destroy(EntityContract $type, Post $post): RedirectResponse
    {
        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);

        $type->delete($post);

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.posts.type', [
            'type' => $type->slug,
        ])->with([
            'restore' => route('platform.posts.restore', $post->id),
        ]);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        $post = Post::onlyTrashed()->find($id);
        $post->restore();

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.posts.type', [
            'type' => $post->type,
            'slug' => $post->id,
        ]);
    }
}
