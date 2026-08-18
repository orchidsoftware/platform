<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:side-menu')]
class SideMenuCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:side-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new SideMenu class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'SideMenu';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('sideMenu.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Layouts';
    }
}
