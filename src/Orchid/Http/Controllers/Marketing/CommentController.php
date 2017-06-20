<?php

namespace Orchid\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use Orchid\Alert\Facades\Alert;
use Orchid\Core\Models\Comment;
use Orchid\Http\Controllers\Controller;
use Orchid\Http\Forms\Marketing\Comment\CommentFormGroup;

class CommentController extends Controller
{
    /**
     * @var CommentFormGroup
     */
    public $form;

    /**
     * CommentController constructor.
     *
     * @param CommentFormGroup $form
     */
    public function __construct(CommentFormGroup $form)
    {
        $this->checkPermission('dashboard.marketing.comment');
        $this->form = $form;
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $this->form->save($request, $comment);

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.marketing.comment.edit', $comment->id);
    }

    /**
     * @param Comment $comment
     *
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $this->form->remove($comment);

        Alert::success(trans('dashboard::common.alert.success'));

        return redirect()->route('dashboard.marketing.comment');
    }
}
