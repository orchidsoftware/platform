<?php

declare(strict_types=1);

namespace Orchid\Platform\Events;

use Orchid\Platform\Http\Forms\Category\CategoryFormGroup;

class CategoryEvent
{
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
