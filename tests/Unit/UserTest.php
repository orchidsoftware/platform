<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Orchid\Access\UserSwitch;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class UserTest extends TestUnitCase
{
    public function testHasCorrectInstance(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testCanGetNameTitle(): void
    {
        $user = $this->createUser();

        $this->assertEquals($user->name, $user->presenter()->title());
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        return User::factory()->create();
    }

    public function testCanGetSubTitle(): void
    {
        $user = $this->createUser();

        $this->assertEquals('Regular user', $user->presenter()->subTitle());
    }

    public function testLoginAs(): void
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
