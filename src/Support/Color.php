<?php

declare(strict_types=1);

namespace Orchid\Support;

enum Color
{
    /**
     * Visual style.
     */
    case INFO;
    case SUCCESS;
    case WARNING;
    case BASIC;
    case DEFAULT;
    case DANGER;
    case PRIMARY;
    case SECONDARY;
    case LIGHT;
    case DARK;
    case LINK;
    case ERROR;

    public function name(): string
    {
        return match ($this) {
            Color::INFO    => 'info',
            Color::SUCCESS => 'success',
            Color::WARNING => 'warning',
            Color::BASIC, Color::DEFAULT => 'default',
            Color::DANGER, Color::ERROR => 'danger',
            Color::PRIMARY   => 'primary',
            Color::SECONDARY => 'secondary',
            Color::LIGHT     => 'light',
            Color::DARK      => 'dark',
            Color::LINK      => 'link',
        };
    }

    /**
     * To temporarily maintain backwards compatibility to 13.0
     *
     *
     * @return \Closure|\Orchid\Support\Color
     */
    public static function __callStatic($name, $arguments)
    {
        return collect(Color::cases())
            ->filter(fn (Color $color) => $color->name === $name)
            ->first() ?? Color::BASIC;
    }
}
