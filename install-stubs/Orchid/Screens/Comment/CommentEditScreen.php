<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Comment;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Orchid\Press\Models\Comment;
use Orchid\Support\Facades\Alert;
use App\Orchid\Layouts\Comment\CommentEditLayout;

class CommentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Comments';
    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'User Comments';

    /**
     * Query data.
     *
     * @param \Orchid\Press\Models\Comment $comment
     *
     * @return array
     */
    public function query(Comment $comment): array
    {
        return [
            'comment' => $comment,
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
            Link::name(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Link::name(__('Remove'))
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
        $comment
            ->fill($request->get('comment'))
            ->save();

        Alert::info(__('Comment was saved'));

        return redirect()->route('platform.systems.comments');
    }

    /**
     * @param Comment $comment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Comment $comment)
    {
        $comment->delete();

        Alert::info(__('Comment was removed'));

        return redirect()->route('platform.systems.comments');
    }
}
