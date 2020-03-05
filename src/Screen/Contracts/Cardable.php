<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

interface Cardable
{
    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function descriptions(): string;

    /**
     * @return string
     */
    public function image(): ?string;

    /**
     * @return mixed
     */
    public function status();

    /**
     * @return mixed
     */
    public function users();
}
