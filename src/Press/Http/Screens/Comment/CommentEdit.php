<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens\Comment;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Link;
use Orchid\Press\Models\Comment;
use Orchid\Support\Facades\Alert;
use Orchid\Platform\Screen\Screen;
use Orchid\Platform\Screen\Layouts;
use Orchid\Platform\Http\Layouts\Comment\CommentEditLayout;

class CommentEdit extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::systems/comment.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::systems/comment.description';

    /**
     * Query data.
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
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(trans('platform::common.commands.save'))
                ->icon('icon-check')
                ->method('save'),
            Link::name(trans('platform::common.commands.remove'))
                ->icon('icon-trash')
                ->method('remove'),
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
            Layouts::columns([
                'CommentEdit' => [
                    CommentEditLayout::class,
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

        Alert::info(trans('platform::systems/comment.Comment was saved'));

        return redirect()->route('platform.systems.comment');
    }

    /**
     * @param $comment
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Comment $comment)
    {
        $comment->delete();

        Alert::info(trans('platform::systems/comment.Comment was removed'));

        return redirect()->route('platform.systems.comment');
    }
}
