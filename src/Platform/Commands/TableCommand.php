<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\GeneratorCommand;
use Orchid\Platform\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:table')]
class TableCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new table layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Table';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return Dashboard::path('stubs/table.stub');
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
