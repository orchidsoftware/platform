<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Comment;

use Orchid\Press\Models\Comment;
use Illuminate\Contracts\View\View;
use Orchid\Platform\Forms\FormGroup;
use Orchid\Platform\Events\CommentEvent;

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
    public function attributes() : array
    {
        return [
            'name'        => trans('platform::systems/comment.title'),
            'description' => trans('platform::systems/comment.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main() : View
    {
        $comments = (new Comment())::with([
            'post' => function ($query) {
                $query->select('id', 'type', 'slug');
            },
        ])->latest()->paginate();

        return view('platform::container.systems.comment.grid', [
            'comments' => $comments,
        ]);
    }
}
