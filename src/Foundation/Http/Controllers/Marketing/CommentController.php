<?php

namespace Orchid\Foundation\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\Comment;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Marketing\Comment\CommentFormGroup;

class CommentController extends Controller
{
    /**
     * @var
     */
    public $form = CommentFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $this->form->save($request,$comment);

        return redirect()->route('dashboard.marketing.comment.edit', $comment->id);
    }

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function edit(Comment $comment)
    {
        return $this->form
            ->route('dashboard.marketing.comment.update')
            ->slug($comment->id)
            ->method('PUT')
            ->render($comment);
    }


    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $this->form->remove($comment);

        return redirect()->route('dashboard.marketing.comment');
    }
}
