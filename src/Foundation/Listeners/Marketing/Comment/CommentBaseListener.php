<?php

namespace Orchid\Foundation\Listeners\Marketing\Comment;

use Orchid\Foundation\Events\Marketing\CommentEvent;
use Orchid\Foundation\Http\Forms\Marketing\Comment\BaseCommentForm;

class CommentBaseListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param CommentEvent $event
     */
    public function handle(CommentEvent $event)
    {
        return BaseCommentForm::class;
    }
}
