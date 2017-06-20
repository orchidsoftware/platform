<?php

namespace Orchid\Listeners\Marketing\Comment;

use Orchid\Http\Forms\Marketing\Comment\BaseCommentForm;

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
     * @return string
     *
     * @internal param CommentEvent $event
     */
    public function handle()
    {
        return BaseCommentForm::class;
    }
}
