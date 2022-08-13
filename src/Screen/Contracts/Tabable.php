<?php

namespace Orchid\Screen\Contracts;

use Orchid\Screen\Field;

interface Tabable extends Fieldable
{
    /**
     * @return Field[]
     */
    public function getTab(): array;

    /**
     * @param array $tab
     *
     * @return Tabable
     */
    public function setTab(array $tab = []): self;
}
