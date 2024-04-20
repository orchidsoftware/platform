<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Orchid\Access\Impersonation;
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
     * @param array|null $attributes
     */
    private function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    public function testCanGetSubTitle(): void
    {
        $user = $this->createUser();

        $this->assertEquals('Regular User', $user->presenter()->subTitle());
    }

    public function testLoginAs(): void
    {
        $user = $this->createUser();
        $userSwitch = $this->createUser();

        $this->assertFalse(Impersonation::isImpersonating());

        $this->actingAs($user);
        $this->assertEquals($user->id, Auth::id());

        Impersonation::loginAs($userSwitch);

        $this->assertTrue(Impersonation::isImpersonating());
        $this->assertEquals($userSwitch->id, Auth::id());

        Impersonation::logout();

        $this->assertEquals($user->id, Auth::id());
    }

    public function testImpersonator(): void
    {
        $user = $this->createUser();
        $userSwitch = $this->createUser();

        $this->actingAs($user);
        $this->assertEquals($user->id, Auth::id());

        $this->assertEquals(null, Impersonation::impersonator());

        Impersonation::loginAs($userSwitch);

        $this->assertEquals($user->id, Impersonation::impersonator()->id);

        Impersonation::logout();

        $this->assertEquals(null, Impersonation::impersonator());
    }

    public function testLoginAsLimit(): void
    {
        $user = $this->createUser([
            'permissions' => [],
        ]);

        $userSwitch = $this->createUser([
            'permissions' => [],
        ]);

        $this->assertFalse(Impersonation::isSwitch());
        $this->actingAs($user);

        $this
            ->get(route('platform.main'))
            ->assertStatus(403);

        Impersonation::loginAs($userSwitch);

        $this->assertTrue(Impersonation::isSwitch());

        $this
            ->get(route('platform.main'))
            ->assertStatus(200)
            ->assertSee('Limited Access');
    }
}
