<?php

declare(strict_types=1);

namespace Orchid\Tests\Browser;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Orchid\Platform\Models\User;
use Orchid\Tests\TestBrowserCase;

class UserEditTest extends TestBrowserCase
{
    public function testOpeningAnotherUserAfterValidationFailureLoadsTheirValues(): void
    {
        $admin = $this->createAdminUser();
        $selected = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $selected) {
            $browser->loginAs($admin)
                ->visitRoute('orchid.users')
                ->pressAndWaitFor($selected->email)
                ->waitFor('input[name="user[email]"]')
                ->type('user[name]', 'Unsaved draft')
                ->type('user[email]', $admin->email)
                ->press('Apply')
                ->waitFor('.modal.show .invalid-feedback')
                ->press('Close')
                ->waitUntilMissing('.modal.show')
                ->pressAndWaitFor($admin->email)
                ->waitUntilMissing('.modal-loading')
                ->assertInputValue('user[email]', $admin->email)
                ->assertInputValue('user[name]', $admin->name)
                ->type('user[name]', 'Updated administrator')
                ->press('Apply')
                ->waitForText('User was saved.');
        });

        $this->assertSame($selected->name, $selected->fresh()->name);
        $this->assertSame('Updated administrator', $admin->fresh()->name);
    }

    public function testModalKeepsSelectedUserAcrossValidationFailure(): void
    {
        $admin = $this->createAdminUser();
        $selected = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $selected) {
            $browser->loginAs($admin)
                ->visitRoute('orchid.users')
                ->pressAndWaitFor($selected->email)
                ->waitFor('input[name="user[email]"]')
                ->assertInputValue('user[email]', $selected->email)
                ->type('user[name]', 'Updated target')
                ->type('user[email]', $admin->email)
                ->press('Apply')
                ->waitFor('.modal.show .invalid-feedback')
                ->assertInputValue('user[name]', 'Updated target')
                ->type('user[email]', $selected->email)
                ->press('Apply')
                ->waitForText('User was saved.')
                ->waitForText('Updated target')
                ->pressAndWaitFor($admin->email)
                ->waitFor('input[name="user[email]"]')
                ->assertInputValue('user[email]', $admin->email)
                ->assertInputValue('user[name]', $admin->name)
                ->press('Close');
        });

        $this->assertSame('Updated target', $selected->fresh()->name);
        $this->assertSame($admin->name, $admin->fresh()->name);
    }

    public function testDeleteFromListSendsSelectedUserThroughConfirmation(): void
    {
        $admin = $this->createAdminUser();
        $selected = User::factory()->create();

        $this->browse(function (Browser $browser) use ($admin, $selected) {
            $browser->loginAs($admin)
                ->visitRoute('orchid.users')
                ->with('tbody tr:first-child', function (Browser $row) use ($selected) {
                    $row->assertSee($selected->email)
                        ->click('button[data-bs-toggle="dropdown"]')
                        ->press('Delete');
                })
                ->waitFor('#confirm-dialog.show')
                ->click('#confirm-dialog button[type="submit"]')
                ->waitForText('User was removed');
        });

        $this->assertNull($selected->fresh());
        $this->assertNotNull($admin->fresh());
    }

    public function testEditPage(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $email = $this->faker()->safeEmail();
            $browser
                ->loginAs($user)
                ->visitRoute('orchid.users')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('orchid.users.edit', ['user' => $user])
                ->waitFor('input[name="user[email]"]')
                ->assertInputValue('user[email]', $user->email)
                ->type('user[email]', $email)
                ->press('Save')
                ->waitForRoute('orchid.users')
                ->waitForText('User was saved.')
                ->clickLink($user->name, 'table a')
                ->waitForRoute('orchid.users.edit', ['user' => $user])
                ->waitFor('input[name="user[email]"]')
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
                ->visitRoute('orchid.users')
                ->assertSee('User Management')
                ->assertSee('A comprehensive list of all registered users, including their profiles and privileges');
        });
    }

    public function testListAsync(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createAdminUser();
            $string = Str::random(5);

            $browser
                ->loginAs($user)
                ->visitRoute('orchid.users')
                ->pressAndWaitFor($user->email)
                ->waitFor('input[name="user[name]"]')
                ->type('user[name]', $string)
                ->press('Apply')
                ->waitForText('User was saved.', 10)
                ->waitForText($string)
                ->assertSee($string);
        });
    }
}
