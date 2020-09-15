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
    public function testArtisanOrchidChart(): void
    {
        $this->artisan('orchid:chart', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Chart created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidTable(): void
    {
        $this->artisan('orchid:table', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Table created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidScreen(): void
    {
        $this->artisan('orchid:screen', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Screen created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidRows(): void
    {
        $this->artisan('orchid:rows', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Rows created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidFilter(): void
    {
        $this->artisan('orchid:filter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Filter created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidSelection(): void
    {
        $this->artisan('orchid:selection', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Selection created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidMetrics(): void
    {
        $this->artisan('orchid:metrics', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Metric created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidListener(): void
    {
        $this->artisan('orchid:listener', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Listener created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidPresenter(): void
    {
        $this->artisan('orchid:presenter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Presenter created successfully.')
            ->assertExitCode(0);
    }

    public function testArtisanOrchidAdmin(): void
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

    public function testArtisanOrchidInstall(): void
    {
        $this->artisan('orchid:install')
            ->expectsOutput("To start the embedded server, run 'artisan serve'");
    }

    public function testArtisanOrchidLink(): void
    {
        $this->artisan('orchid:link')
            ->expectsOutput('Links have been created.');
    }
}
