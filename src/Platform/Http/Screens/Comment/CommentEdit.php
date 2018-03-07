<?php

namespace Orchid\Platform\Http\Screens\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Facades\Dashboard;

use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

use Orchid\Platform\Http\Layouts\Comment\CommentEditLayout;

class CommentEdit extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'dashboard::systems/comment.title';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'dashboard::systems/comment.description';

    /**
     * Query data
     *
     * @param int $commentId
     *
     * @return array
     */
    public function query($commentId = null): array
    {
        $comment = is_null($commentId) ? new Comment : Comment::findOrFail($commentId);
        return [
            'comment' => $comment,
        ];

    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(' '.trans('dashboard::common.commands.save'))->icon('icon-check')->method('save'),
            Link::name(' '.trans('dashboard::common.commands.remove'))->icon('icon-trash')->method('remove'),
        ];
    }

    /**
     * Views
     *
     * @return array
     */

    public function layout(): array
    {
        return [
            Layouts::columns([
                'CommentEdit' => [
                    CommentEditLayout::class
                ],
            ]),

        ];
    }

    /**
     * @param          $commentId
     * @param Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($commentId, Request $request)
    {
        
        $comment = is_null($commentId) ? new Comment : Comment::findOrFail($commentId);

        $attributes = $request->get('comment');
        
        $comment->content =$attributes['content'];
        $comment->approved = array_key_exists('approved',$attributes) ? "1" : "0";

        $comment->save();

        Alert::info(trans('dashboard::systems/comment.Comment was saved'));

        return redirect()->route('dashboard.systems.comment');
    }

    /**
     * @param  $commentId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($commentId)
    {

        $comment = is_null($commentId) ? new Comment : Comment::findOrFail($commentId);
        
        $comment->delete();

        Alert::info(trans('dashboard::systems/comment.Comment was removed'));

        return redirect()->route('dashboard.systems.comment');
    }

}
