<?php

namespace Orchid\Events\Marketing;

use Illuminate\Queue\SerializesModels;
use Orchid\Http\Forms\Marketing\Comment\CommentFormGroup;

class CommentEvent
{
    use SerializesModels;

    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     *
     * @param CommentFormGroup $form
     */
    public function __construct(CommentFormGroup $form)
    {
        $this->form = $form;
    }
}
