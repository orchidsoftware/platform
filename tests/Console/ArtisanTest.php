<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Illuminate\Support\Str;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;
use Orchid\Tests\TestConsoleCase;
use Generator;

class ArtisanTest extends TestConsoleCase
{

    /**
     * @return Generator
     */
    public function artisanOrchidMake(): Generator
    {
        yield ['Chart', 'orchid:chart', 'Orchid/Layouts/'];
        yield ['Table', 'orchid:table', 'Orchid/Layouts/'];
        yield ['Rows', 'orchid:rows', 'Orchid/Layouts/'];
        yield ['Selection', 'orchid:selection', 'Orchid/Layouts/'];
        yield ['Listener', 'orchid:listener', 'Orchid/Layouts/'];
        yield ['TabMenu', 'orchid:tab-menu', 'Orchid/Layouts/'];

        yield ['Presenter', 'orchid:presenter', 'Orchid/Presenters/'];
        yield ['Screen', 'orchid:screen', 'Orchid/Screens/'];
        yield ['Filter', 'orchid:filter', 'Orchid/Filters/'];
    }

    /**
     * @param string $name
     * @param string $command
     * @param string $path
     *
     * @dataProvider artisanOrchidMake
     */
    public function testArtisanOrchidMake(string $name, string $command, string $path):void
    {
        $file = Str::random();

        $this->artisan($command, ['name' => $file])
            ->expectsOutputToContain($name)
            ->expectsOutputToContain("created successfully.")
            ->assertOk();

        $this->assertFileExists(app_path($path.$file.'.php'));
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
}
