<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestFeatureCase;

class AccessTest extends TestFeatureCase
{
    public function testAccessMiddleware()
    {
        $user = factory(User::class)->create([
            'permissions' => [
                'access.to.public.data' => 1,
                'access.to.secret.data' => 0,
            ],
        ]);

        $this->actingAs($user);

        $this->get('/_test/accessMiddlewarePublicData')
            ->assertStatus(200);

        $this->get('/_test/accessMiddlewarePrivateData')
            ->assertStatus(403);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(Access::class . ':access.to.public.data')
            ->any('/_test/accessMiddlewarePublicData', function () {
                return 'OK';
            });

        Route::middleware(Access::class . ':access.to.private.data')
            ->any('/_test/accessMiddlewarePrivateData', function () {
                return 'OK';
            });
    }
}
