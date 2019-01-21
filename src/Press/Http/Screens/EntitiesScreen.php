<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens;

use App\Orchid\Entities\Post;
use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\EntityContract;
use Orchid\Press\Http\Layouts\EntitiesLayout;
use Orchid\Press\Entities\Many;
use Orchid\Press\Http\Layouts\EntitiesSelection;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;

class EntitiesScreen extends Screen
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
     * @var array
     */
    protected $grid = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var Many
     */
    protected $entity;

    /**
     *
     */
    public const POST_PERMISSION_PREFIX = 'platform.posts.type.';

    /**
     * Query data.
     *
     * @param Many $type
     *
     * @return array
     */
    public function query(Many $type): array
    {
        $this->name = $type->name;
        $this->description = $type->description;
        $this->entity = $type;

        $this->checkPermission(static::POST_PERMISSION_PREFIX.$type->slug);

        $this->grid = $type->grid();
        $this->filters = $type->filters();

        return [
            'data' => $type->get()
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
                ->link(route('platform.posts.type.create',$this->entity->slug))
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
            new EntitiesSelection($this->filters),
            new EntitiesLayout($this->grid)
        ];
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

        Alert::success(__('Operation completed successfully.'));

        return back();
    }
}
