<?php

declare(strict_types=1);

namespace Orchid\Widget;

/**
 * Interface WidgetContractInterface.
 */
interface WidgetContractInterface
{
    /**
     * @param $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param mixed
     *
     * @return mixed
     */
    public function handler();
}
