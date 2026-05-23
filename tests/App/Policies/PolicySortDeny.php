<?php

declare(strict_types=1);

namespace Orchid\Tests\App\Policies;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Policy for tests: forbids sorting to assert that SortableController
 * respects the policy and returns 403 when isSortable() returns false.
 */
class PolicySortDeny
{
    public function isSortable(?Authenticatable $user): bool
    {
        return false;
    }
}
