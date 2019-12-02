<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Platform;

use Illuminate\Support\Facades\Auth;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class UserTest extends TestUnitCase
{
    /**
     */
    public function testHasCorrectInstance()
    {
        $user = factory(User::class)->create();

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     */
    public function testCanGetNameTitle()
    {
        $user = $this->createUser();

        $this->assertEquals($user->name, $user->getNameTitle());
    }

    /**
     * @return User
     */
    private function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     */
    public function testCanGetSubTitle()
    {
        $user = $this->createUser();

        $this->assertEquals('Administrator', $user->getSubTitle());
    }

    public function testLoginAs()
    {
        $user = $this->createUser();
        $userSwitch = $this->createUser();

        $this->assertFalse(UserSwitch::isSwitch());

        $this->actingAs($user);
        $this->assertEquals($user->id, Auth::id());

        UserSwitch::loginAs($userSwitch);

        $this->assertTrue(UserSwitch::isSwitch());
        $this->assertEquals($userSwitch->id, Auth::id());

        UserSwitch::logout();

        $this->assertEquals($user->id, Auth::id());
    }
}
