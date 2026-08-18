<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\Database\Factory\DatabaseNotificationFactory;
use Orchid\Tests\TestBrowserCase;

class NotificationTest extends TestBrowserCase
{
    public function testNotificationBadgeSwitchesToIndicatorForDoubleDigitCounts(): void
    {
        $user = $this->createAdminUser();

        DatabaseNotificationFactory::new()
            ->count(9)
            ->for($user, 'notifiable')
            ->create();

        $this->browse(function (Browser $browser) use ($user) {
            $badge = '[data-notification-target="badge"]';

            $browser
                ->loginAs($user)
                ->visitRoute(config('orchid.index'))
                ->waitFor("{$badge}:not(.d-none)")
                ->assertSeeIn($badge, '9')
                ->assertMissing("{$badge} svg");

            DatabaseNotificationFactory::new()
                ->count(2)
                ->for($user, 'notifiable')
                ->create();

            $browser
                ->refresh()
                ->waitFor("{$badge} svg")
                ->assertDontSeeIn($badge, '10');
        });
    }
}
