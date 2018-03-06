<?php

namespace Orchid\Platform\Http\Screens\Comment;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

use Orchid\Platform\Core\Models\Comment;

use Orchid\Platform\Http\Layouts\Comment\CommentListLayout;

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
    public function query() : array
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
    public function layout() : array
    {
        return [
            CommentListLayout::class,
        ];
    }

}
