<?php

namespace Orchid\Platform\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeColumns extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new columns layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Columns';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() : string
    {
        return DASHBOARD_PATH . '/resources/stubs/layouts/columns.stub';
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
        return $rootNamespace . '\Http\Layouts';
    }
}
