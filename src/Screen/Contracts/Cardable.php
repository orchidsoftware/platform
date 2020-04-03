<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Orchid\Support\Color;

interface Cardable
{
    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
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
