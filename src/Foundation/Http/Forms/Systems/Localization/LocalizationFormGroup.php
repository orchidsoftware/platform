<?php

namespace Orchid\Foundation\Http\Forms\Systems\Localization;

use Orchid\Foundation\Core\Models\Language;
use Orchid\Foundation\Events\Systems\LocalizationEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class LocalizationFormGroup extends FormGroup
{
    /**
     * @var string
     */
    public $view = 'dashboard::container.systems.localization.localization';

    /**
     * @var
     */
    public $event = LocalizationEvent::class;

    /**
     * LocalizationFormGroup constructor.
     */
    public function __construct()
    {
        $registerForm = event(new $this->event($this));
        $this->group = collect($registerForm);
        $this->storage = collect();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grid()
    {
        $localization = new Language();

        $localizations = $localization->select(
            'id', 'name', 'status', 'created_at'
        )->paginate();

        return view('dashboard::container.systems.localization.grid', [
            'localizations' => $localizations,
        ]);
    }
}
