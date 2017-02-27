<?php

namespace Orchid\Foundation\Http\Forms\Marketing\Advertising;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Core\Models\Post;
use Orchid\Foundation\Events\Marketing\AdvertisingEvent;

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
    public function attributes()
    {
        return [
            'name'        => 'Реклама',
            'description' => 'Управление контентом рекламы и его размещением',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        return view('dashboard::container.marketing.advertising.grid', [
            'ads' => Post::type('advertising')->paginate(),
        ]);
    }
}
