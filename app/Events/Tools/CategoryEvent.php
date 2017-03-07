<?php

namespace Orchid\Events\Tools;

use Illuminate\Queue\SerializesModels;
use Orchid\Http\Forms\Tools\Category\CategoryFormGroup;

class CategoryEvent
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
     * @param CategoryFormGroup $form
     */
    public function __construct(CategoryFormGroup $form)
    {
        $this->form = $form;
    }
}
