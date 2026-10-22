<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Orchid\Support\Color;

interface Cardable
{
    /**
     * Return the card title.
     */
    public function title(): string;

    /**
     * Return the card description.
     */
    public function description(): string;

    /**
     * @return string
     */
    public function image(): ?string;

    /**
     * @return Color
     */
    public function color(): ?Color;
}
