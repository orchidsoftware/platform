<?php

declare(strict_types=1);

namespace Orchid\Screen\Presenters;

interface MiniCard
{
    /**
     * @return string
     */
    public function id(): ?string;

    /**
     * @return string
     */
    public function image(): ?string;
}
