<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Comment;

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
     * Validation Rules Request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'name'        => 'required|max:255|unique:roles,name,'.$this->request->get('name').',name',
            //'slug'        => 'required|max:255|unique:roles,slug,'.$this->request->get('slug').',slug',
            //'permissions' => 'array',
        ];
    }

    /**
     * Display Settings App.
     *
     * @param Comment|null $comment
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function get(Comment $comment)
    {
        return view('dashboard::container.marketing.comment.info', [
            'comment' => $comment,
            'post'    => $post = $comment->post()->first(),
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
