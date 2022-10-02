<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;
use Orchid\Tests\TestConsoleCase;

class ArtisanTest extends TestConsoleCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug.
     *
     * @var
     */
    public function testArtisanOrchidChart(): void
    {
        $this->artisan('orchid:chart', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidTable(): void
    {
        $this->artisan('orchid:table', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidScreen(): void
    {
        $this->artisan('orchid:screen', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidRows(): void
    {
        $this->artisan('orchid:rows', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidFilter(): void
    {
        $this->artisan('orchid:filter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidSelection(): void
    {
        $this->artisan('orchid:selection', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidListener(): void
    {
        $this->artisan('orchid:listener', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidPresenter(): void
    {
        $this->artisan('orchid:presenter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }

    public function testArtisanOrchidAdmin(): void
    {
        $this->artisan('orchid:admin')
            ->expectsQuestion('What is your name?', 'testConsoleCreateUser')
            ->expectsQuestion('What is your email?', 'testConsoleCreateUser@console.loc')
            ->expectsQuestion('What is the password?', 'testConsoleCreateUser')
            ->expectsOutputToContain('User created successfully.');

        $this->artisan('orchid:admin')
            ->expectsQuestion('What is your name?', 'testConsoleCreateUser')
            ->expectsQuestion('What is your email?', 'testConsoleCreateUser@console.loc')
            ->expectsQuestion('What is the password?', 'testConsoleCreateUser')
            ->expectsOutputToContain('User exist');

        $user = User::factory()->create([
            'permissions' => [],
        ]);

        $this->assertEquals([], $user->permissions);

        $this->artisan('orchid:admin', ['--id' => $user->id])
            ->expectsOutputToContain('User permissions updated.');

        $user->refresh();

        $this->assertEquals(Dashboard::getAllowAllPermission()->toArray(), $user->permissions);
    }

    public function testArtisanOrchidInstall(): void
    {
        $this->artisan('orchid:install')
            ->expectsOutputToContain("To start the embedded server, run 'artisan serve'")
            ->assertOk();
    }

    public function testArtisanOrchidLink(): void
    {
        $this->artisan('orchid:publish')
            ->assertOk();
    }

    public function testArtisanOrchidTabMenu(): void
    {
        $this->artisan('orchid:tab-menu', ['name' => $this->generateNameFromMethod()])
            ->expectsOutputToContain('created successfully.')
            ->assertOk();
    }
}
