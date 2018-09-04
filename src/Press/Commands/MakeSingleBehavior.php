<?php

declare(strict_types=1);

namespace Orchid\Press\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeSingleBehavior extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:entity-single';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new entity class';

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
        return PLATFORM_PATH.'/resources/stubs/single.stub';
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
        return $rootNamespace.'\Orchid\Entities';
    }
}
