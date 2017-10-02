<?php

namespace Orchid\Platform\Listeners\Comment;

use Orchid\Platform\Http\Forms\Comment\BaseCommentForm;

class CommentBaseListener
{
    /**
     * Handle the event.
     *
     * @return string
     *
     * @internal param CommentEvent $event
     */
    public function handle()
    {
        return BaseCommentForm::class;
    }
}
