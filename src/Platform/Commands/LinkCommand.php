<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Orchid\Platform\Dashboard;

class LinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link from resource orchid';

    /**
     * Execute the console command.
     *
     * @param Dashboard  $dashboard
     * @param Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Dashboard $dashboard, Filesystem $filesystem)
    {
        $prefix = public_path('resources');

        $filesystem->ensureDirectoryExists($prefix);

        $dashboard->getPublicDirectory()->each(function ($path, $package) use ($prefix, $filesystem) {
            $package = $prefix.'/'.$package;
            $path = rtrim($path, '/');

            if (! $filesystem->exists($package)) {
                $filesystem->link($path, $package);
                $this->line("The [$package] directory has been linked.");
            }
        });

        $this->info('Links have been created.');
    }
}
