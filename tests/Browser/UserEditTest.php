<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class UserEditTest extends TestBrowserCase
{
    public function testListPage(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();

            $browser
                ->loginAs($user, 'web')
                ->assertAuthenticatedAs($user)
                ->visitRoute('platform.systems.users')
                ->assertSee('User')
                ->assertSee('All registered users');
        });
    }

    public function testListAsync(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();

            $browser->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->press($user->email)
                ->waitForText($user->email)
                ->waitForText($user->name)
                ->waitForText('Close')
                ->waitForText('Apply')
                ->type('user[name]', $user->name.'-async-test')
                ->press('Apply')
                ->waitForText('User was saved.')
                ->assertSee($user->name.'-async-test');
        });
    }

    public function testEditPage(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();

            $browser->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('platform.systems.users.edit', $user)
                ->type('user[name]', $user->name.'-edit-test')
                ->press('Save')
                ->waitForRoute('platform.systems.users')
                ->assertSee('User was saved.')
                ->assertSee($user->name.'-edit-test');
        });
    }
}
