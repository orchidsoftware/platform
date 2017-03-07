<?php

namespace Orchid\Listeners\Marketing\Advertising;

use Orchid\Http\Forms\Marketing\Advertising\AdvertisingCodeForm;

class AdvertisingCodeListener
{
    public function handle()
    {
        return AdvertisingCodeForm::class;
    }
}
