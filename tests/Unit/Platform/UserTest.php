<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class UserTest extends TestUnitCase
{
    /**
     * @test
     */
    public function it_has_the_correct_instance()
    {
        $user = factory(User::class)->create();

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function it_can_get_name_title()
    {
        $user = $this->createUser();

        $this->assertEquals($user->name, $user->getNameTitle());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * @test
     */
    public function it_can_get_sub_title()
    {
        $user = $this->createUser();

        $this->assertEquals('Administrator', $user->getSubTitle());
    }
}
