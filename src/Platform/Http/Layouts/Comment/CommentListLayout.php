<?php

namespace Orchid\Platform\Http\Layouts\Comment;

use Orchid\Platform\Layouts\Table;
use Orchid\Platform\Fields\TD;

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
                ->title(trans('dashboard::systems/comment.status'))
                ->setRender(function ($comment) {
                    if($comment->approved) {
                        return '<i class="icon-check mx-3"></i>';
                    } else {
                        return '<i class="icon-close mx-3"></i>';
                    }
                }), 
            TD::name('content')
                ->title(trans('dashboard::systems/comment.content'))
                ->setRender(function ($comment) {
                    return '<a href="'.route('dashboard.systems.comment.edit',
                        $comment->id).'">'.$comment->content.'</a>';
                }), 
            TD::name('post_id')
                ->title(trans('dashboard::systems/comment.recording'))
                ->setRender(function ($comment) {
                    if(!is_null($comment->post)) {
                        return '<a href="'.route('dashboard.posts.type.edit',[
                                  $comment->post->type,
                                  $comment->post->id
                        ]).'">'.trans('dashboard::systems/comment.go').'</a>';
                    } else {
                        return trans('dashboard::systems/comment.delete');
                    }
                }),  
            TD::name('user_id')
                ->title(trans('dashboard::systems/comment.user'))
                ->setRender(function ($comment) {
                    return '<a href="'.route('dashboard.systems.users.edit',
                        $comment->user_id).'">'.trans('dashboard::systems/comment.go').'</a>';
                }),               
            TD::name('updated_at')
                ->title(trans('dashboard::common.Last edit'))
                ->setRender(function ($comment) {
                    return $comment->updated_at;
                }),

        ];
    }
}
