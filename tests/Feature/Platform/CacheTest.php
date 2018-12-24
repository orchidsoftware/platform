<?php

declare(strict_types=1);

namespace Tests\Feature\Platform;

use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class CacheTest extends TestFeatureCase
{

    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @return array
     */
    public function routeCache()
    {
        return [
            ['cache'],
            //['config'],
            //['route'],
            ['view'],
            //['opcache']
        ];
    }

    /**
     * @param string $route
     *
     * @dataProvider routeCache
     * @throws \Throwable
     */
    public function test_cache_reset_route(string $route)
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('platform.systems.cache',[
                'action' => $route
            ]));

        $response->assertStatus(302);
    }

}