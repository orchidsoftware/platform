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
        //dd($return);
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [
            Link::name(' '.trans('dashboard::common.commands.add'))->icon('icon-plus')->method('create'),
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

    /**
     * @param Request $request
     *
     * @return null
     */
    public function create()
    {
        return redirect()->route('dashboard.systems.comment.create');
    }
}
