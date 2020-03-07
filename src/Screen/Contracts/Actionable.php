<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Orchid\Screen\Repository;

interface Actionable
{
    /**
     * @param Repository $repository
     *
     * @return mixed
     */
    public function build(Repository $repository);
}
