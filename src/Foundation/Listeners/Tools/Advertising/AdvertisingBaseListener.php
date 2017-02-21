<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.02.17
 * Time: 13:55.
 */

namespace Orchid\Foundation\Listeners\Tools\Advertising;

use Orchid\Foundation\Events\Tools\AdvertisingEvent;
use Orchid\Foundation\Http\Forms\Tools\Advertising\AdvertisingMainForm;

class AdvertisingBaseListener
{
    public function handle(AdvertisingEvent $event)
    {
        return AdvertisingMainForm::class;
    }
}
