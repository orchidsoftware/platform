<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

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
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.users'));
        $response->assertStatus(200);
        $this->assertContains($this->user->name, $response->baseResponse->content());
        $this->assertContains($this->user->email, $response->baseResponse->content());
    }

    public function test_route_SystemsUsersEdit()
    {
        $response = $this->actingAs($this->user)
            ->get(route('platform.systems.users.edit', $this->user->id));
        $response->assertStatus(200);
        $this->assertContains($this->user->name, $response->baseResponse->content());
        $this->assertContains($this->user->email, $response->baseResponse->content());
    }

    public function test_route_SystemsUsersEdit_remove()
    {
        $response = $this->actingAs($this->user)
            ->post(route('platform.systems.users.edit', [$this->user->id, 'remove']));

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/users');
    }
}
