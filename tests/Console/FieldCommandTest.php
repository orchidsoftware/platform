<?php

declare(strict_types=1);

namespace Orchid\Tests\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Orchid\Tests\TestConsoleCase;

class FieldCommandTest extends TestConsoleCase
{
    private string $name;

    private string $classPath;

    private string $viewPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'Test'.Str::random(10);
        $this->classPath = app_path('Orchid/Fields/'.$this->name.'.php');
        $this->viewPath = resource_path('views/orchid/fields/'.Str::kebab($this->name).'.blade.php');
    }

    protected function tearDown(): void
    {
        File::delete([$this->classPath, $this->viewPath]);

        parent::tearDown();
    }

    public function testCreatesClassAndView(): void
    {
        $this->artisan('orchid:field', ['name' => $this->name])->assertOk();

        $this->assertFileExists($this->classPath);
        $this->assertFileExists($this->viewPath);
        $this->assertStringContainsString('orchid.fields.'.Str::kebab($this->name), File::get($this->classPath));
    }

    public function testPreservesAnExistingView(): void
    {
        File::ensureDirectoryExists(dirname($this->viewPath));
        File::put($this->viewPath, 'Existing view');

        $this->artisan('orchid:field', ['name' => $this->name])
            ->expectsOutputToContain('View already exists.')
            ->assertOk();

        $this->assertSame('Existing view', File::get($this->viewPath));
    }

    public function testDoesNotCreateAViewWhenTheClassAlreadyExists(): void
    {
        File::ensureDirectoryExists(dirname($this->classPath));
        File::put($this->classPath, 'Existing class');

        $this->artisan('orchid:field', ['name' => $this->name])
            ->expectsOutputToContain('Field already exists.');

        $this->assertSame('Existing class', File::get($this->classPath));
        $this->assertFileDoesNotExist($this->viewPath);
    }
}
