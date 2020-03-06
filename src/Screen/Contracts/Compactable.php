<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface Compactable
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
