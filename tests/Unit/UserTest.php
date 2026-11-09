<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use App\Orchid\Presenters\UserPresenter;
use Illuminate\Support\Facades\Auth;
use Orchid\Access\Impersonation;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestUnitCase;

class UserTest extends TestUnitCase
{
    public function testInvalidImpersonationGuardPreservesTheOriginalUser(): void
    {
        Auth::viaRequest('stateless', fn () => null);
        config()->set('auth.guards.stateless', ['driver' => 'stateless']);
        config()->set('orchid.guard', 'stateless');
        session()->put(Impersonation::SESSION_NAME, 123);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Impersonation requires a session guard.');

        try {
            Impersonation::logout();
        } finally {
            $this->assertSame(123, session()->get(Impersonation::SESSION_NAME));
        }
    }

    public function testHasCorrectInstance(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testCanGetNameTitle(): void
    {
        $user = $this->createUser();
        $presenter = $user->presenter();
        $this->assertInstanceOf(UserPresenter::class, $presenter);

        $this->assertEquals($user->name, $presenter->title());
    }

    private function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    public function testCanGetSubTitle(): void
    {
        $user = $this->createUser();
        $presenter = $user->presenter();
        $this->assertInstanceOf(UserPresenter::class, $presenter);

        $this->assertEquals('Regular User', $presenter->subTitle());
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

        $this->assertEquals($user->getAuthIdentifier(), Impersonation::impersonator()->getAuthIdentifier());

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
            ->get(route('orchid.main'))
            ->assertStatus(403);

        Impersonation::loginAs($userSwitch);

        $this->assertTrue(Impersonation::isSwitch());

        $this
            ->get(route('orchid.main'))
            ->assertStatus(200)
            ->assertSee('Limited Access');
    }
}
