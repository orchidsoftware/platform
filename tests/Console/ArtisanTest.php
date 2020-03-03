<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Orchid\Tests\TestConsoleCase;

class ArtisanTest extends TestConsoleCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug.
     *
     * @var
     */
    public function testArtisanOrchidChart()
    {
        $this->artisan('orchid:chart', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Chart created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidTable()
    {
        $this->artisan('orchid:table', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Table created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidScreen()
    {
        $this->artisan('orchid:screen', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Screen created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidRows()
    {
        $this->artisan('orchid:rows', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Rows created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidFilter()
    {
        $this->artisan('orchid:filter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Filter created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidSelection()
    {
        $this->artisan('orchid:selection', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Selection created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidMetrics()
    {
        $this->artisan('orchid:metrics', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Metric created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidAdmin()
    {
        $this->artisan('orchid:admin')
            ->expectsQuestion('What is your name?', 'testConsoleCreateUser')
            ->expectsQuestion('What is your email?', 'testConsoleCreateUser@console.loc')
            ->expectsQuestion('What is the password?', 'testConsoleCreateUser')
            ->expectsOutput('User created successfully.');

        $this->artisan('orchid:admin')
            ->expectsQuestion('What is your name?', 'testConsoleCreateUser')
            ->expectsQuestion('What is your email?', 'testConsoleCreateUser@console.loc')
            ->expectsQuestion('What is the password?', 'testConsoleCreateUser')
            ->expectsOutput('User exist');
    }

    public function testArtisanOrchidInstall()
    {
        $this->artisan('orchid:install')
            ->expectsOutput("To start the embedded server, run 'artisan serve'");
    }

    public function testArtisanOrchidLink()
    {
        $this->artisan('orchid:link')
            ->expectsOutput('Links have been created.');
    }

    public function testArtisanPresetOrchidSource()
    {
        $this->artisan('ui', ['type' => 'orchid-source'])
            ->expectsOutput('Please run "npm install && npm run dev" to compile your fresh scaffolding.')
            ->expectsOutput('Orchid scaffolding installed successfully.');
    }

    public function testArtisanPresetOrchid()
    {
        $this->artisan('ui', ['type' => 'orchid'])
            ->expectsOutput('Please run "npm install && npm run dev" to compile your fresh scaffolding.')
            ->expectsOutput("After that, You need to add this line to AppServiceProvider's register method:")
            ->expectsOutput("app(\Orchid\Platform\Dashboard::class)->registerResource('scripts','/js/dashboard.js');")
            ->expectsOutput('Orchid scaffolding installed successfully.');
    }
}
