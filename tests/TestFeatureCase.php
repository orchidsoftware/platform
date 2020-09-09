<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use Orchid\Platform\Models\User;

/**
 * Class TestUnitCase.
 */
abstract class TestFeatureCase extends TestCase
{
    use Environment;

    /**
     * @var User
     */
    private $user;

    /**
     * @return User
     */
    protected function createAdminUser(): User
    {
        if ($this->user === null) {
            $this->user = User::factory()->create();
        }

        return $this->user;
    }
}
