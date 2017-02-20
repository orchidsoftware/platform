<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 17.02.17
 * Time: 11:31.
 */

namespace Orchid\Foundation\Listeners\Tools\Advertising;

use Orchid\Foundation\Events\Tools\AdvertisingEvent;
use Orchid\Foundation\Http\Forms\Tools\Advertising\AdvertisingPreviewForm;

class AdvertisingPreviewListener
{
    public function handle(AdvertisingEvent $event)
    {
        return AdvertisingPreviewForm::class;
    }
}
