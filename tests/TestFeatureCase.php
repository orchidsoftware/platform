<?php

declare(strict_types=1);

namespace Orchid\Tests;

use Orchid\Platform\Models\User;
use Orchestra\Testbench\TestCase;

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
    protected function createAdminUser()
    {
        if (is_null($this->user)) {
            $this->user = factory(User::class)->create();
        }

        return $this->user;
    }
}
