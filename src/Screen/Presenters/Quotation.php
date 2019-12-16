<?php

declare(strict_types=1);

namespace Orchid\Screen\Presenters;

interface Quotation extends Personable
{
    /**
     * @return string
     */
    public function date(): string;

    /**
     * @return string
     */
    public function message(): string;
}
