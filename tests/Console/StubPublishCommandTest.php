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

        $this->filesystem = new Filesystem();
        $this->stubsPath = base_path('stubs/orchid/platform');
        $this->filesystem->ensureDirectoryExists($this->stubsPath);
    }

    /**
     * Clears the directory after each test.
     */
    protected function tearDown(): void
    {
        $this->filesystem->deleteDirectory($this->stubsPath);
        parent::tearDown();
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
