<?php

declare(strict_types=1);

namespace Orchid\Support;

use MyCLabs\Enum\Enum;

/**
 * Class Color.
 *
 * @psalm-immutable
 *
 * All colors available in package,
 * are available as constants
 *
 * @method static string|Color INFO()
 * @method static string|Color SUCCESS()
 * @method static string|Color WARNING()
 * @method static string|Color DEFAULT()
 * @method static string|Color DANGER()
 * @method static string|Color PRIMARY()
 * @method static string|Color SECONDARY()
 * @method static string|Color LIGHT()
 * @method static string|Color DARK()
 * @method static string|Color LINK()
 * @method static string|Color ERROR()
 */
class Color extends Enum
{
    /**
     * Visual style.
     */
    private const INFO = 'info';
    private const SUCCESS = 'success';
    private const WARNING = 'warning';
    private const DEFAULT = 'default';
    private const DANGER = 'danger';
    private const PRIMARY = 'primary';
    private const SECONDARY = 'secondary';
    private const LIGHT = 'light';
    private const DARK = 'dark';
    private const LINK = 'link';
    private const ERROR = self::DANGER;
}
