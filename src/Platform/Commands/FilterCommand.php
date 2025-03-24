<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:filter')]
class FilterCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('filters.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Filters';
    }
}
