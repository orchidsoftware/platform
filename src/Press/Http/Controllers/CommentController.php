<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Press\Models\Comment;
use Orchid\Support\Facades\Alert;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Forms\Comment\CommentFormGroup;

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
        $this->checkPermission('platform.systems.comment');
        $this->form = $form;
    }

    /**
     * @return bool
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

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.systems.comment.edit', $comment->id);
    }

    /**
     * @param Comment $comment
     *
     * @return mixed
     */
    public function edit(Comment $comment)
    {
        return $this->form
            ->route('platform.systems.comment.update')
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

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.systems.comment');
    }
}
