<?php

namespace Orchid\Http\Forms\Marketing\Advertising;

use Illuminate\Contracts\View\View;
use Orchid\Forms\FormGroup;
use Orchid\Core\Models\Post;
use Orchid\Events\Marketing\AdvertisingEvent;

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
    public function attributes() : array
    {
        return [
            'name'        => 'Реклама',
            'description' => 'Управление контентом рекламы и его размещением',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main() : View
    {
        return view('dashboard::container.marketing.advertising.grid', [
            'ads' => Post::type('advertising')->paginate(),
        ]);
    }
}
