<?php

namespace Orchid\Tests\App\Screens;

class OverriddenScreenView extends BaseScreenTesting
{
    public function screenBaseView(): string
    {
        return 'exemplar::overriding.screen';
    }
}
