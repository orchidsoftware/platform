<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Illuminate\Contracts\View\View;

interface Fieldable
{
    /**
     * The process of creating.
     */
    public function render(): ?View;

    public function get(string $key, mixed $value = null): mixed;

    public function set(string $key, mixed $value): static;

    public function getAttributes(): array;
}
