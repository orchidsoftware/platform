<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Press\Models\Post;
use Orchid\Press\Entities\Many;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\RedirectResponse;
use Orchid\Press\Entities\EntityContract;
use Orchid\Press\Http\Layouts\EntitiesLayout;
use Orchid\Press\Http\Layouts\EntitiesSelection;

class EntityListScreen extends Screen
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

    public const POST_PERMISSION_PREFIX = 'platform.entities.type.';

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
            'data' => $type->get(),
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
                ->link(route('platform.entities.type.create', $this->entity->slug)),
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
            Layouts::view('platform::container.posts.restore'),
            new EntitiesSelection($this->filters),
            new EntitiesLayout($this->grid),
        ];
    }

    /**
     * @param EntityContract $type
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function restore(EntityContract $type, int $id) : RedirectResponse
    {
        Post::onlyTrashed()->findOrFail($id)->restore();

        Alert::success(__('Operation completed successfully.'));

        return redirect()->route('platform.entities.type', [
            'type' => $type->slug,
        ]);
    }
}
