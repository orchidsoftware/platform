<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 10:43
 */

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;

use Orchid\Forms\FormGroup;
use Orchid\Foundation\Events\Tools\AdvertisingEvent;

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
        return view('dashboard::container.tools.advertising.grid');
    }
}