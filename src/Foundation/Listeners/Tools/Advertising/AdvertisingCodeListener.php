<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 17.02.17
 * Time: 10:14
 */

namespace Orchid\Foundation\Listeners\Tools\Advertising;


use Orchid\Foundation\Events\Tools\AdvertisingEvent;
use Orchid\Foundation\Http\Forms\Tools\Advertising\AdvertisingCodeForm;

class AdvertisingCodeListener
{
    public function handle(AdvertisingEvent $event)
    {
        return AdvertisingCodeForm::class;
    }
}