<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Support\Str;
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

    /**
     * Execute the console command.
     *
     * @return bool Whether the command execution was successful.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
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
     *
     * @return string The path to the stub file.
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

    /**
     * Get the view name based on the field name input.
     *
     * @param string $separator The separator to use for the view path.
     *
     * @return string The formatted view name.
     */
    protected function getView($separator = '.'): string
    {
        return Str::of($this->getNameInput())
            ->replace('\\', '/')
            ->explode('/')
            ->map(fn ($segment) => Str::kebab($segment))
            ->prepend('fields')
            ->prepend('orchid')
            ->implode($separator);
    }

    /**
     * Generate the Blade view file for the field.
     *
     * @return void
     */
    protected function writeView(): void
    {
        $path = $this->viewPath(
            sprintf('%s.blade.php', $this->getView('/'))
        );

        $this->makeDirectory($path);

        if ($this->files->exists($path) && ! $this->option('force')) {
            $this->components->error('View already exists.');

            return;
        }

        $stubPath = $this->resolveStubPath('field.blade.stub');


        $this->files->copy($stubPath, $path);
        $this->files->replaceInFile('{{ controller }}', $this->getStimulusControllerName(), $path);

        $this->components->info(sprintf('View [%s] created successfully.', $path));
    }

    /**
     * Derive the Stimulus controller name based on the class name argument.
     *
     * @return string The Stimulus controller name.
     */
    protected function getStimulusControllerName(): string
    {
        return Str::of($this->getNameInput())
            ->classBasename()
            ->snake('-')
            ->toString();
    }

    /**
     * Build the class with additional replacements.
     *
     * @param string $name The class name.
     *
     * @return string The processed class stub.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        return str_replace('{{ view }}', $this->getView(), $stub);
    }
}
