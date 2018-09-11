<?php

namespace Orchid\Tests\Unit\Press;

use Orchid\Tests\TestUnitCase;
use Orchid\Platform\Models\User;

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
    public function it_can_getNameTitle()
    {
        $user = $this->createUser();

        $this->assertEquals($user->name, $user->getNameTitle());
    }

    /**
     * @test
     */
    public function it_can_getSubTitle()
    {
        $user = $this->createUser();

        $this->assertEquals('Administrator', $user->getSubTitle());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function createUser()
    {
        $user = factory(User::class)->create();

        return $user;
    }
}
