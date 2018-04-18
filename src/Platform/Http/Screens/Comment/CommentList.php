<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\Comment;

use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Http\Layouts\Comment\CommentListLayout;
use Orchid\Platform\Screen\Screen;

class CommentList extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'dashboard::systems/comment.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'dashboard::systems/comment.description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'comment' => Comment::with([
                'post' => function ($query) {
                    $query->select('id', 'type', 'slug');
                },
            ])->latest()->paginate(),
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
            CommentListLayout::class,
        ];
    }
}
