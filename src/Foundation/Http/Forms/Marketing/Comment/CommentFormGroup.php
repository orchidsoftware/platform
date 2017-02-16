<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Comment;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Core\Models\Comment;
use Orchid\Foundation\Events\Marketing\CommentEvent;

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
    public function attributes()
    {
        return [
            'name'        => 'Комментарии',
            'description' => 'Пользовательские комментарии',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        $comments = (new Comment())->with(['post'=> function ($query) {
            $query->select('id', 'type', 'slug');
        }])->orderBy('id', 'desc')->paginate();

        return view('dashboard::container.marketing.comment.grid', [
            'comments' => $comments,
        ]);
    }
}
