<?php
declare(strict_types=1);
namespace App\Orchid\Layouts\Comment;
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
                ->setRender(function ($comment) {
                    if($comment->approved) {
                        return '<i class="icon-check mx-3"></i>';
                    } else {
                        return '<i class="icon-close mx-3"></i>';
                    }
                }),

            TD::name('content')
                ->title(trans('platform::systems/comment.content'))
                ->setRender(function ($comment) {
                    return '<a href="'.route('platform.systems.comments.edit',
                            $comment->id).'">'.str_limit($comment->content, 70).'</a>';
                }),

           TD::name('post_id')
               ->title(trans('platform::systems/comment.recording'))
               ->setRender(function ($comment) {
                   if(!is_null($comment->post)) {
                       return '<a href="'.route('platform.posts.type.edit',[
                               $comment->post->type,
                               $comment->post->id
                           ]).'"><i class="icon-text-center mx-3"></i></a>';
                   } else {
                       return '<i class="icon-close mx-3"></i>';
                   }
               })
               ->align('center'),
           TD::name('user_id')
               ->title(trans('platform::systems/comment.user'))
               ->setRender(function ($comment) {
                   return '<a href="'.route('platform.systems.users.edit',
                           $comment->user_id).'"><i class="icon-user mx-3"></i></a>';
               })
                ->align('center'),
           TD::name('updated_at')
               ->title(trans('platform::common.Last edit'))
               ->setRender(function ($comment) {
                   return $comment->updated_at;
               }),
        ];
    }
}