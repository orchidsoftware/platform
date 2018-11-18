<?php

declare(strict_types=1);

use Orchid\Bulldozer\Http\Screens\BootModelScreen;

$this->screen('/{model?}', BootModelScreen::class)->name('platform.bulldozer.index');
