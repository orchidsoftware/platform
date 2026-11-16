<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Screens;

use Orchid\Screen\Screen;

class TypedPropertiesScreen extends Screen
{
    public int $clicks;

    public ?string $message = 'Default message';

    public function layout(): iterable
    {
        return [];
    }
}
