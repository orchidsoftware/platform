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
    protected $name = 'orchid:field';

    protected $description = 'Create a new field class';

    protected $type = 'Field';

    protected $signature = 'orchid:field {name} {--controller}';

    public function handle(): bool
    {
        $this->writeView();

        if ($this->option('controller')) {
            $this->writeJsController();
            $this->updateDashboardJs();
        }

        return true;
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

        $stubPath = Dashboard::path('stubs/field/field.blade.stub');
        if (! $this->files->exists($stubPath)) {
            $this->components->error('Stub file not found.');

            return;
        }

        $viewStub = $this->files->get($stubPath);
        if (! $this->option('controller')) {
            $viewStub = str_replace('data-controller="{{ jsControllerKebab }}"', '', $viewStub);
        }

        $stub = str_replace(
            '{{ jsControllerName }}',
            Str::kebab($this->getJsControllerName()),
            $viewStub
        );

        $this->files->put($path, $stub);
        $this->components->info(sprintf('View [%s] created successfully.', $path));
    }

    protected function writeJsController(): void
    {
        $path = resource_path('js/controllers/'.$this->getJsControllerName().'.js');

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        if ($this->files->exists($path) && ! $this->option('force')) {
            $this->components->error('JS Controller already exists.');

            return;
        }

        $stubPath = Dashboard::path('stubs/field/stimulus-controller.stub');
        if (! $this->files->exists($stubPath)) {
            $this->components->error('Stub file not found.');

            return;
        }

        $stub = str_replace('{{ jsControllerName }}', $this->getJsControllerName(), $this->files->get($stubPath));
        $this->files->put($path, $stub);

        $this->components->info(sprintf('JS Controller [%s] created successfully.', $path));
    }

    protected function updateDashboardJs(): void
    {
        $dashboardPath = resource_path('js/dashboard.js');

        $importStatement = sprintf(
            'import %sController from "./controllers/%s";',
            $this->getJsControllerName(),
            $this->getJsControllerName()
        );
        $registerStatement = sprintf(
            'application.register("%s", %sController);',
            Str::kebab($this->getJsControllerName()),
            $this->getJsControllerName()
        );

        if (! $this->files->exists($dashboardPath)) {
            $content = $this->files->get(Dashboard::path('stubs/field/dashboard.js.stub'));
            $this->files->put($dashboardPath, $content);
            $this->components->info('dashboard.js created and updated.');

            return;
        }

        $content = $this->files->get($dashboardPath);

        if (! str_contains($content, $importStatement)) {
            $content = $importStatement."\n".$content;
        }

        if (! str_contains($content, $registerStatement)) {
            $content .= "\n".$registerStatement."\n";
        }

        $this->files->put($dashboardPath, $content);
        $this->components->info('dashboard.js updated.');
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

    protected function getJsControllerName(): string
    {
        return Str::studly(class_basename($this->argument('name')));
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('field/field.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Orchid\Fields';
    }

    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        return str_replace('{{ viewName }}', $this->getView(), $stub);
    }
}
