<?php

namespace Orchid\Http\Forms\Marketing\Advertising;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\Post;
use Orchid\Events\Marketing\AdvertisingEvent;
use Orchid\Forms\FormGroup;

class AdvertisingFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = AdvertisingEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'        => trans('dashboard::marketing/advertising.title'),
            'description' => trans('dashboard::marketing/advertising.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        return view('dashboard::container.marketing.advertising.grid', [
            'ads' => Post::type('advertising')->paginate(),
        ]);
    }
}
