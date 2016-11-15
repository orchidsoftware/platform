<?php namespace Orchid\Foundation\Http\Forms\Systems\Localization;

use Orchid\Foundation\Core\Models\Language;
use Orchid\Foundation\Core\Models\Role;
use Orchid\Foundation\Events\Systems\LocalizationEvent;
use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Services\Forms\FormGroup;

class LocalizationFormGroup extends FormGroup
{

    /**
     * @var string
     */
    public $view = 'dashboard::container.systems.localization.localization';

    public $event = LocalizationEvent::class;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grid() {
        $localization = new Language();

        $localizations = $localization->select(
            'id', 'name', 'status', 'created_at'
        )->paginate();

        return view('dashboard::container.systems.localization.grid', [
            'localizations' => $localizations
        ]);
    }
}
