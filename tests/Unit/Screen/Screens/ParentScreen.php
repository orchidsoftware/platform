<?php

namespace Orchid\Tests\Unit\Screen\Screens;

use Orchid\Screen\Screen;

class ParentScreen extends Screen
{
    public ?string $parentProperty1 = null;
    public ?string $parentProperty2 = null;

    public function layout(): iterable
    {
        return [];
    }
}
