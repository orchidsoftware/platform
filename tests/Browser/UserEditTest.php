<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class UserEditTest extends TestBrowserCase
{
    public function testEditPage(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $email = $this->faker()->safeEmail;
            $browser
                ->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('platform.systems.users.edit', $user)
                ->pause(500)
                ->assertInputValue('user[email]', $user->email)
                ->type('user[email]', $email)
                ->press('Save')
                ->waitForRoute('platform.systems.users')
                ->waitForText('User was saved.')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('platform.systems.users.edit', $user)
                ->pause(500)
                ->assertInputValue('user[email]', $email);
        });
    }

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
            $string = Str::random(5);

            $browser
                ->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->press($user->email)
                ->pause(500)
                ->type('user[name]', $string)
                ->press('Apply')
                ->waitForText('User was saved.', 10)
                ->waitForText($string, 10)
                ->assertSee($string);
        });
    }
}
