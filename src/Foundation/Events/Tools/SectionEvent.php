<?php

namespace Orchid\Foundation\Events\Tools;

use Illuminate\Queue\SerializesModels;
use Orchid\Foundation\Http\Forms\Tools\Section\SectionFormGroup;

class SectionEvent
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
     * @param SectionFormGroup $form
     */
    public function __construct(SectionFormGroup $form)
    {
        $this->form = $form;
    }
}
