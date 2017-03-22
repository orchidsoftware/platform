<?php

namespace Orchid\Listeners\Marketing\Advertising;

use Orchid\Http\Forms\Marketing\Advertising\AdvertisingCodeForm;

class AdvertisingCodeListener
{
    /**
     * @return string
     */
    public function handle()
    {
        return AdvertisingCodeForm::class;
    }
}
