<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class ExampleScreenTest extends TestFeatureCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= UserTest tests\\Feature\\Example\\UserTest --debug.
     * @var
     */
    private $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_route_platform_example()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.example'));

        $response->assertOk()
            ->assertSee('Example Screen')
            ->assertSee('Sample Screen Components');
    }
}
