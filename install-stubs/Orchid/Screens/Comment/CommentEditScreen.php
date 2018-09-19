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
    public function save($id, Request $request)
    {
        $newcomment = $request->get('comment');
        /*
        if (array_key_exists('approved',$newcomment) ) {
            $newcomment['approved'] = 1;
        } else {
            $newcomment['approved'] = 0;
        }*/
        //dd($newcomment);
        $comment = Comment::findOrFail($id);
        $comment->fill($newcomment)->save();
        Alert::info(trans('platform::systems/comment.Comment was saved'));

        return redirect()->route('platform.systems.comments');
    }

    /**
     * @param $comment
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($id)
    {
        Comment::findOrFail($id)->delete();
        Alert::info(trans('platform::systems/comment.Comment was removed'));

        return redirect()->route('platform.systems.comments');
    }
}
