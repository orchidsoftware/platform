<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\GeneratorCommand;
use Orchid\Platform\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:tab-menu')]
class TabMenuCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:tab-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new TabMenu class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'TabMenu';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return Dashboard::path('stubs/tabMenu.stub');
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
