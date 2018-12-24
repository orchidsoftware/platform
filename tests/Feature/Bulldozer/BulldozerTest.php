<?php

declare(strict_types=1);

namespace Tests\Feature\Bulldozer;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class BulldozerTest extends TestFeatureCase
{
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_open_screen()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.bulldozer.index'));

        $response->assertStatus(200);
    }
}
