<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Events\PublishingStubs;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:stubs')]
class StubsCommand extends Command
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
    public function handle()
    {
        if (! is_dir($stubsPath = $this->laravel->basePath('stubs/orchid/platform'))) {
            (new Filesystem())->makeDirectory($stubsPath, recursive: true);
        }

        $stubs = [
            __DIR__.'/../../../stubs/chart.stub'     => 'chart.stub',
            __DIR__.'/../../../stubs/filters.stub'   => 'filters.stub',
            __DIR__.'/../../../stubs/listener.stub'  => 'listener.stub',
            __DIR__.'/../../../stubs/presenter.stub' => 'presenter.stub',
            __DIR__.'/../../../stubs/rows.stub'      => 'rows.stub',
            __DIR__.'/../../../stubs/screen.stub'    => 'screen.stub',
            __DIR__.'/../../../stubs/selection.stub' => 'selection.stub',
            __DIR__.'/../../../stubs/table.stub'     => 'table.stub',
            __DIR__.'/../../../stubs/tabMenu.stub'   => 'tabMenu.stub',
        ];

        $this->laravel['events']->dispatch($event = new PublishingStubs($stubs));

        foreach ($event->stubs as $from => $to) {
            $to = $stubsPath.'/'.ltrim($to, '/');

            if ((! $this->option('existing') && (! file_exists($to) || $this->option('force')))
                || ($this->option('existing') && file_exists($to))) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->components->info('Stubs published successfully.');
    }
}
