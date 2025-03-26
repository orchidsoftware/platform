<?php

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;

abstract class GeneratorCommand extends \Illuminate\Console\GeneratorCommand
{
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        $path = $this->laravel->basePath('stubs/orchid/platform/'.trim($stub, '/'));

        return file_exists($path)
            ? $path
            : Dashboard::path('stubs/'.$stub);
    }
}
