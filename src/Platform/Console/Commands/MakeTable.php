<?php

declare(strict_types=1);

namespace Orchid\Platform\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeTable extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:table';

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
     *
     * @return string
     */
    protected function getStub() : string
    {
        return DASHBOARD_PATH.'/resources/stubs/table.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) : string
    {
        return $rootNamespace.'\Layouts';
    }
}
