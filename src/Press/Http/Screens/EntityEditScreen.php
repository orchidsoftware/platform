<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Press\Models\Post;
use Orchid\Press\Entities\Many;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\EntityContract;

class EntityEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name;

    /**
     * Display header description.
     *
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $permission;

    /**
     * @var EntityContract
     */
    protected $entity;

    /**
     * @var bool
     */
    protected $exist = false;

    /**
     * Query data.
     *
     * @param EntityContract $type
     * @param Post           $post
     *
     * @return array
     */
    public function query(EntityContract $type, Post $post): array
    {
        $this->name = $type->name;
        $this->description = $type->description;
        $this->entity = $type;
        $this->exist = $post->exists;

        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);

        return [
            'locales' => collect($type->locale()),
            'type'    => $type,
            'post'    => $type->create($post),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(__('Create'))
                ->icon('icon-check')
                ->method('save')
                ->canSee(! $this->exist),

            Link::name(__('Remove'))
                ->icon('icon-trash')
                ->method('destroy')
                ->canSee($this->exist && is_a($this->entity, Many::class)),

            Link::name(__('Save'))
                ->icon('icon-check')
                ->method('save')
                ->canSee($this->exist),

            Link::view('platform::container.posts.menu'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::view('platform::container.posts.edit'),
        ];
    }

    /**
     * @param Request        $request
     * @param EntityContract $type
     * @param Post           $post
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return RedirectResponse
     */
    public function save(Request $request, EntityContract $type, Post $post): RedirectResponse
    {
        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);
        $type->isValid();

        $post->fill($request->all())->fill([
            'type'    => $type->slug,
            'user_id' => $request->user()->id,
            'options' => $post->getOptions(),
        ]);

        $type->save($post);

        Alert::success(__('Operation completed successfully.'));

        $route = is_a($type, Many::class)
            ? 'platform.entities.type'
            : 'platform.entities.type.page';

        return redirect()->route($route, [
            'type' => $post->type,
            'slug' => $post->slug,
        ]);
    }

    /**
     * @param EntityContract $type
     * @param Post           $post
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
        $this->checkPermission(Post::POST_PERMISSION_PREFIX.$type->slug);

        $type->delete($post);

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.entities.type', [
            'type' => $type->slug,
        ])->with([
            'restore' => route('platform.entities.type', [
                'type' => $type->slug,
                $post->id,
                'restore',
            ]),
        ]);
    }
}
