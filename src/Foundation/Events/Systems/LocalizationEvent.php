<?php namespace Orchid\Foundation\Events\Systems;

use Illuminate\Queue\SerializesModels;
use Orchid\Foundation\Http\Forms\Systems\Localization\LocalizationFormGroup;

class LocalizationEvent
{
    use SerializesModels;

    /**
     * @var
     */
    protected $form;

    /**
     * Create a new event instance.
     * SomeEvent constructor.
     * @param FormGroup $form
     */
    public function __construct(LocalizationFormGroup $form)
    {
        $this->form = $form;
    }
}
