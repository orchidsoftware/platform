<?php

namespace Orchid\Platform\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeSingleBehavior extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:singleBehavior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new behavior class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Behavior';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() : string
    {
        return DASHBOARD_PATH.'/resources/stubs/single.stub';
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
        return $rootNamespace.'\Behaviors\Single';
    }
}
