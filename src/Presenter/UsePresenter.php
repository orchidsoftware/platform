<?php

declare(strict_types=1);

namespace Orchid\Presenter;

use Attribute;

/**
 * Declares which presenter class a model should use by default.
 *
 * Usage:
 *   #[UsePresenter(UserPresenter::class)]
 *   class User extends Model { use Presentable; }
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class UsePresenter
{
    /**
     * @param class-string<Presenter> $presenter
     */
    public function __construct(
        public readonly string $presenter,
    ) {}
}
