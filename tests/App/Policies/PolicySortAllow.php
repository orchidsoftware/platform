<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Policies;

use Illuminate\Contracts\Auth\Authenticatable;

class PolicySortAllow
{
    public function isSortable(?Authenticatable $user): bool
    {
        return true;
    }
}
