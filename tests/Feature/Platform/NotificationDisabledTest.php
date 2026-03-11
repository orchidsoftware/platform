<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Orchid\Tests\TestFeatureCase;

class NotificationDisabledTest extends TestFeatureCase
{
    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        config()->set('orchid.notifications.enabled', false);
    }

    public function testRouteForDisabledNotification(): void
    {
        $this->assertFalse(Route::has('orchid.notifications'));
        $this->assertFalse(Route::has('orchid.api.notifications'));
    }
}
