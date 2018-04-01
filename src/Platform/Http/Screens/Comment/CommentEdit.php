<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\Comment;

use Illuminate\Http\Request;
use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Facades\Alert;
use Orchid\Platform\Http\Layouts\Comment\CommentEditLayout;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Screen\Link;
use Orchid\Platform\Screen\Screen;

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
     * @param int $id
     *
     * @return array
     */
    public function query($id = null): array
    {
        return [
            'comment' => Comment::findOrFail($id),
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
            Link::name(trans('dashboard::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('dashboard::common.commands.remove'))
                ->icon('icon-trash')
                ->method('remove'),
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
     * @param Comment $comment
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Comment $comment, Request $request)
    {
        $comment->fill($request->get('comment'))->save();

        Alert::info(trans('dashboard::systems/comment.Comment was saved'));

        return redirect()->route('dashboard.systems.comment');
    }

    /**
     * @param $comment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Comment $comment)
    {
        $comment->delete();

        Alert::info(trans('dashboard::systems/comment.Comment was removed'));

        return redirect()->route('dashboard.systems.comment');
    }

}
