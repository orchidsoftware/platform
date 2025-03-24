<?php

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;

abstract class GeneratorCommand extends \Illuminate\Console\GeneratorCommand
{
    /**
     * @param string $stub
     *
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($path = $this->laravel->basePath('stubs/orchid/platform/'.trim($stub, '/')))
            ? $path
            : Dashboard::path('stubs/'.$stub);
    }
}
