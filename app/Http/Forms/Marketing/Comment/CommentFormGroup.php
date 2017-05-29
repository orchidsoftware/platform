<?php

namespace Orchid\Http\Forms\Marketing\Comment;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\Comment;
use Orchid\Events\Marketing\CommentEvent;
use Orchid\Forms\FormGroup;

class CommentFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = CommentEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('dashboard::marketing/comment.title'),
            'description' => trans('dashboard::marketing/comment.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        $comments = (new Comment())->with([
            'post' => function ($query) {
                $query->select('id', 'type', 'slug');
            },
        ])->orderBy('id', 'desc')->paginate();

        return view('dashboard::container.marketing.comment.grid', [
            'comments' => $comments,
        ]);
    }
}
