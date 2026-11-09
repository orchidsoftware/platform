<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Http\Request;
use Orchid\Tests\TestFeatureCase;

class UserTest extends TestFeatureCase
{
    public function testProfileSavesSubmittedInputInsteadOfRequestAttributes(): void
    {
        $user = $this->createAdminUser();
        $request = Request::create('/dashboard/profile?user[name]=Query', 'POST', [
            'user' => ['name' => 'Submitted', 'email' => $user->email],
        ]);
        $request->attributes->set('user', ['name' => 'Attribute', 'email' => 'other@example.com']);
        $request->setUserResolver(static fn () => $user);

        (new UserProfileScreen)->save($request);

        $this->assertSame('Submitted', $user->fresh()->name);
        $this->assertSame($user->email, $user->fresh()->email);
    }

    public function testRouteSystemsUsers(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.users'));

        $response->assertOk()
            ->assertSee($this->createAdminUser()->name)
            ->assertSee($this->createAdminUser()->email);
    }

    public function testRouteSystemsUsersCreate(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->get(route('orchid.users.create'));

        $response->assertOk()
            ->assertSee('field-user');
    }

    public function testRouteSystemsUsersEdit(): void
    {
        $user = $this->createAdminUser();

        $this
            ->actingAs($user)
            ->get(route('orchid.users.edit', $user->id))
            ->assertSee($user->name)
            ->assertSee($user->email);
    }

    public function testRouteSystemsUsersEditRemove(): void
    {
        $response = $this
            ->actingAs($this->createAdminUser())
            ->post(route('orchid.users.edit', [$this->createAdminUser()->id, 'remove']));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/users');
    }
}
