<?php

namespace App\Orchid\Core\Contracts;

use Orchid\Screen\Field;
use Orchid\Screen\Contracts\Fieldable;

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
