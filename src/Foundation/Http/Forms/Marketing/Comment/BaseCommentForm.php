<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Comment;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Comment;
use Orchid\Foundation\Facades\Alert;

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
        return view('dashboard::container.marketing.comment.info', [
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
        Alert::success('Message');
    }

    /**
     * @param Comment $comment
     */
    public function delete(Comment $comment)
    {
        $comment->delete();
        Alert::success('Message');
    }
}
