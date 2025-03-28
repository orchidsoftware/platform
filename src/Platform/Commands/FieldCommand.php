<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Orchid\Platform\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:field')]
class FieldCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'orchid:field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new field class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Field';

    public function handle(): bool
    {
        if (! parent::handle()) {
            $this->writeView();

            return true;
        }

        return false;
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('field.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Fields';
    }

    protected function getView(): string
    {
        $segments = explode('/', str_replace('\\', '/', $this->argument('name')));
        $name = array_pop($segments);
        $path = ['orchid', 'fields', $name];

        return (new Collection($path))
            ->map(fn ($segment) => Str::kebab($segment))
            ->implode('.');
    }

    protected function writeView(): void
    {
        $path = $this->viewPath(
            str_replace('.', '/', $this->getView()).'.blade.php'
        );

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        if ($this->files->exists($path) && ! $this->option('force')) {
            $this->components->error('View already exists.');

            return;
        }

        $stubPath = Dashboard::path('stubs/field.blade.stub');

        if (! $this->files->exists($stubPath)) {
            $this->components->error('Stub file not found.');

            return;
        }

        $stub = str_replace(
            '{{ controller }}',
            Str::kebab($this->getStimulusControllerName()),
            $this->files->get($stubPath)
        );

        $this->files->put($path, $stub);
        $this->components->info(sprintf('View [%s] created successfully.', $path));
    }

    protected function getStimulusControllerName(): string
    {
        return Str::studly(class_basename($this->argument('name')));
    }

    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        return str_replace('{{ view }}', $this->getView(), $stub);
    }
}
