<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Comment;

use Orchid\Forms\Form;
use Illuminate\Http\Request;
use Orchid\Press\Models\Comment;
use Illuminate\Contracts\View\View;

class BaseCommentForm extends Form
{
    /**
     * @var string
     */
    public $name = 'General Info';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Comment::class;

    /**
     * Display Settings App.
     *
     * @param Comment $comment
     *
     * @return View
     */
    public function get(Comment $comment) : View
    {
        return view('platform::container.systems.comment.info', [
            'comment' => $comment,
            'post'    => $comment->post()->first(),
        ]);
    }

    /**
     * @param Request|null $request
     * @param Comment|null $comment
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, Comment $comment = null)
    {
        $comment->approved = false;
        $comment->fill($request->all());
        $comment->save();
    }

    /**
     * @param Comment $comment
     *
     * @throws \Exception
     */
    public function delete(Comment $comment)
    {
        try {
            $comment->delete();
        } catch (\Exception $e) {
        }
    }
}
