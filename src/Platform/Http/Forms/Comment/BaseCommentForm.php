<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Comment;

use Illuminate\Http\Request;
use Orchid\Platform\Forms\Form;
use Illuminate\Contracts\View\View;
use Orchid\Platform\Core\Models\Comment;

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
     * @param Comment|null $comment
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(Comment $comment) : View
    {
        return view('dashboard::container.systems.comment.info', [
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
