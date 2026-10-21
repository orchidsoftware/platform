<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface Personable
{
    /**
     * Return the person's display name.
     */
    public function title(): string;

    /**
     * Return the secondary text displayed for the person.
     */
    public function subTitle(): string;

    /**
     * Return the person's destination URL.
     */
    public function url(): string;

    /**
     * @return string
     */
    public function image(): ?string;
}
