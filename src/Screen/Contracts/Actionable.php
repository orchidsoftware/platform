<?php

declare(strict_types=1);

namespace Orchid\Screen\Contracts;

use Illuminate\Contracts\View\View;
use Orchid\Screen\Repository;

interface Actionable
{
    public function build(Repository $repository): ?View;
}
