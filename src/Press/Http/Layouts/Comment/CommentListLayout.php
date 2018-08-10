<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Layouts\Comment;

use Orchid\Screen\Fields\TD;
use Orchid\Screen\Layouts\Table;

class CommentListLayout extends Table
{
    /**
     * @var string
     */
    public $data = 'comment';

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters() : array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return  [
            TD::name('approved')
                ->title(trans('platform::systems/comment.status'))
                ->setRender(function($comment) {
                    if ($comment->approved) {
                        return '<i class="icon-check mx-3"></i>';
                    } else {
                        return '<i class="icon-close mx-3"></i>';
                    }
                }),
            TD::name('content')
                ->title(trans('platform::systems/comment.content'))
                ->setRender(function($comment) {
                    return '<a href="'.route('platform.systems.comment.edit',
                        $comment->id).'">'.$comment->content.'</a>';
                }),
            TD::name('post_id')
                ->title(trans('platform::systems/comment.recording'))
                ->setRender(function($comment) {
                    if (!is_null($comment->post)) {
                        return '<a href="'.route('platform.posts.type.edit', [
                                    $comment->post->type,
                                    $comment->post->id,
                        ]).'">'.trans('platform::systems/comment.go').'</a>';
                    } else {
                        return trans('platform::systems/comment.delete');
                    }
                }),
            TD::name('user_id')
                ->title(trans('platform::systems/comment.user'))
                ->setRender(function($comment) {
                    return '<a href="'.route('platform.systems.users.edit',
                        $comment->user_id).'">'.trans('platform::systems/comment.go').'</a>';
                }),
            TD::name('updated_at')
                ->title(trans('platform::common.Last edit'))
                ->setRender(function($comment) {
                    return $comment->updated_at;
                }),

        ];
    }
}
