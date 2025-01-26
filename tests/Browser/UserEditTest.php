<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Orchid\Tests\TestBrowserCase;

class UserEditTest extends TestBrowserCase
{
    public function test_edit_page(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $email = $this->faker()->safeEmail;
            $browser
                ->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('platform.systems.users.edit', $user)
                ->pause(2500)
                ->assertInputValue('user[email]', $user->email)
                ->type('user[email]', $email)
                ->press('Save')
                ->waitForRoute('platform.systems.users')
                ->waitForText('User was saved.')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('platform.systems.users.edit', $user)
                ->pause(2500)
                ->assertInputValue('user[email]', $email);
        });
    }

    public function test_list_page(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $browser
                ->loginAs($user, 'web')
                ->assertAuthenticatedAs($user)
                ->visitRoute('platform.systems.users')
                ->assertSee('User Management')
                ->assertSee('A comprehensive list of all registered users, including their profiles and privileges');
        });
    }

    public function test_list_async(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $string = Str::random(5);

            $browser
                ->loginAs($user)
                ->visitRoute('platform.systems.users')
                ->pressAndWaitFor($user->email)
                ->pause(10000)
                ->type('user[name]', $string)
                ->press('Apply')
                ->waitForText('User was saved.', 10)
                ->pause(10000)
                ->assertSee($string);
        });
    }
}
