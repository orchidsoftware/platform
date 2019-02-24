<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class UserTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= UserTest tests\\Feature\\Example\\UserTest --debug.
     * @var
     */
    private $user;

    public function setUp()
    {
        parent::setUp();
        //$this->withoutMiddleware();
        if ($this->user) {
            return $this->user;
        }
        $this->user = factory(User::class)->create();
    }

    public function test_route_SystemsUsers()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.users'));

        $response->assertOk()
            ->assertSee($this->user->name)
            ->assertSee($this->user->email);
    }

    public function test_route_SystemsUsersEdit()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.users.edit', $this->user->id));

        $response->assertOk()
            ->assertSee($this->user->name)
            ->assertSee($this->user->email);
    }

    public function test_route_SystemsUsersEdit_remove()
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('platform.systems.users.edit', [$this->user->id, 'remove']));

        $response
            ->assertStatus(302)
            ->assertRedirect('/dashboard/users');
    }
}
