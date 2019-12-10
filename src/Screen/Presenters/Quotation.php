<?php

declare(strict_types=1);

namespace Orchid\Screen\Presenters;

interface Quotation extends Profilable
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
