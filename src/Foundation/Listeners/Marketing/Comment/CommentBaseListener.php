<?php

namespace Orchid\Foundation\Listeners\Marketing\Comment;

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
     * @return
     *
     * @internal param CommentEvent $event
     */
    public function handle()
    {
        return BaseCommentForm::class;
    }
}
