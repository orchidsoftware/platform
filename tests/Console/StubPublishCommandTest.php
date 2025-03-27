<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Orchid\Tests\TestConsoleCase;
use Illuminate\Filesystem\Filesystem;

class StubPublishCommandTest extends TestConsoleCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->stubsPath = base_path('stubs/orchid/platform');
    }

    /**
     * Clears the directory after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $filesystem = new Filesystem();
        if ($filesystem->exists($this->stubsPath)) {
            $filesystem->cleanDirectory($this->stubsPath);
        }
    }

    /**
     * Test using the --force option to overwrite an existing file.
     */
    public function testForcePublish(): void
    {
        $file = 'screen.stub';

        // Simulate an existing file.
        file_put_contents($this->stubsPath.'/'.$file, 'Existing content');

        $this->artisan('orchid:stubs', ['--force' => true])
            ->expectsOutputToContain('Stubs published successfully.')
            ->assertOk();

        // Check that the file was overwritten.
        $this->assertNotEquals('Existing content', file_get_contents($this->stubsPath.'/'.$file));
    }

    /**
     * Test using the --existing option to overwrite only existing files.
     */
    public function testExistingPublish(): void
    {
        $file = 'screen.stub';

        // Simulate an existing file.
        file_put_contents($this->stubsPath.'/'.$file, 'Existing content');

        $this->artisan('orchid:stubs', ['--existing' => true])
            ->expectsOutputToContain('Stubs published successfully.')
            ->assertOk();

        // Check that the file was overwritten.
        $this->assertNotEquals('Existing content', file_get_contents($this->stubsPath.'/'.$file));
    }

    /**
     * Test without any options to check normal file publishing behavior.
     */
    public function testPublishWithoutOptions(): void
    {
        $this->artisan('orchid:stubs')
            ->expectsOutputToContain('Stubs published successfully.')
            ->assertOk();
    }
}
