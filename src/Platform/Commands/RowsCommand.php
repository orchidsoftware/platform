<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\GeneratorCommand;

class RowsCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:rows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new rows layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Rows';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return Dashboard::path('resources/stubs/rows.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Layouts';
    }
}
