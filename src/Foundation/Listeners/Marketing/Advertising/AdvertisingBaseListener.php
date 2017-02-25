<?php

namespace Orchid\Foundation\Listeners\Marketing\Advertising;

use Orchid\Foundation\Http\Forms\Marketing\Advertising\AdvertisingMainForm;

class AdvertisingBaseListener
{
    public function handle()
    {
        return AdvertisingMainForm::class;
    }
}
