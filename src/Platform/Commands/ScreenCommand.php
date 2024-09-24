<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\GeneratorCommand;
use Orchid\Platform\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:screen')]
class ScreenCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:screen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new screen class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Screen';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return Dashboard::path('stubs/screen.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Screens';
    }
}
