<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Support\Facades\Route;
use Orchid\Tests\TestFeatureCase;

class NotificationDisabledTest extends TestFeatureCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        config()->set('platform.notifications.enabled', false);
    }

    public function test_route_for_disabled_notification(): void
    {
        $this->assertFalse(Route::has('platform.notifications'));
        $this->assertFalse(Route::has('platform.api.notifications'));
    }
}
