<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface Personable
{
    public function title(): string;

    public function subTitle(): string;

    public function url(): string;

    /**
     * @return string
     */
    public function image(): ?string;
}
