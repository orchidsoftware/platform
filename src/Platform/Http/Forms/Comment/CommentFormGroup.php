<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Forms\Comment;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Forms\FormGroup;
use Orchid\Platform\Core\Models\Comment;
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
            'name'        => trans('dashboard::systems/comment.title'),
            'description' => trans('dashboard::systems/comment.description'),
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

        return view('dashboard::container.systems.comment.grid', [
            'comments' => $comments,
        ]);
    }
}
