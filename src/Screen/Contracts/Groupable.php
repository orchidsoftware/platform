<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Orchid\Screen\Field;

interface Groupable extends Fieldable
{
    /**
     * @return Field[]
     */
    public function getGroup(): array;

    /**
     * @param array $group
     *
     * @return Groupable
     */
    public function setGroup(array $group = []): self;
}
