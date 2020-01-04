<?php

declare(strict_types=1);

namespace Orchid\Support;

use MyCLabs\Enum\Enum;

/**
 * Class Color.
 *
 * All colors available in package,
 * are available as constants
 *
 * @method static Color INFO()
 * @method static Color SUCCESS()
 * @method static Color WARNING()
 * @method static Color DEFAULT()
 * @method static Color DANGER()
 * @method static Color PRIMARY()
 * @method static Color SECONDARY()
 * @method static Color LIGHT()
 * @method static Color DARK()
 * @method static Color LINK()
 * @method static Color ERROR()
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
