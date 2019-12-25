<?php

declare(strict_types=1);

namespace Orchid\Support;

/**
 * Class Color.
 *
 * All colors available in package,
 * are available as constants
 */
class Color
{
    /**
     * Visual style.
     */
    public const INFO = 'info';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DEFAULT = 'default';
    public const DANGER = 'danger';
    public const PRIMARY = 'primary';
    public const SECONDARY = 'secondary';
    public const LIGHT = 'light';
    public const DARK = 'dark';
    public const LINK = 'link';
    public const ERROR = self::DANGER;
}
