<?php


namespace Orchid\Foundation\Listeners\Marketing\Advertising;

use Orchid\Foundation\Http\Forms\Marketing\Advertising\AdvertisingCodeForm;

class AdvertisingCodeListener
{
    public function handle()
    {
        return AdvertisingCodeForm::class;
    }
}
