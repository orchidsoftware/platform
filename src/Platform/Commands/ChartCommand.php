<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\GeneratorCommand;

class ChartCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:chart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new chart layout class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Chart';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return Dashboard::path('resources/stubs/chart.stub');
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
