<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Events\PublishingStubs;
use Orchid\Support\Facades\Dashboard;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:stubs')]
class StubPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orchid:stubs
                    {--existing : Publish and overwrite only the files that have already been published}
                    {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the Orchid stubs that are available for customization';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $stubsPath = $this->laravel->basePath('stubs/orchid/platform');

        $filesystem->ensureDirectoryExists($stubsPath);

        $stubs = collect([
            'chart.stub',
            'filters.stub',
            'listener.stub',
            'presenter.stub',
            'rows.stub',
            'screen.stub',
            'selection.stub',
            'table.stub',
            'tabMenu.stub',
        ])
            ->mapWithKeys(fn (string $file) => [
                Dashboard::path("stubs/{$file}") => $file,
            ]);

        $this->laravel['events']->dispatch($event = new PublishingStubs($stubs->all()));

        foreach ($event->stubs as $from => $to) {
            $to = $stubsPath.'/'.ltrim($to, '/');

            if ($this->shouldPublish($to)) {
                $filesystem->copy($from, $to);
            }
        }

        $this->components->info('Stubs published successfully.');
    }

    /**
     * Determine if the stub file should be published.
     */
    protected function shouldPublish(string $path): bool
    {
        return ! file_exists($path)
            || $this->option('force')
            || ($this->option('existing')
                && file_exists($path));
    }
}
