<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function handle(Dashboard $dashboard)
    {
        $prefix = public_path('resources');

        if (! File::exists($prefix)) {
            File::makeDirectory($prefix, 0755, true);
        }

        $dashboard->getPublicDirectory()->each(function ($path, $package) use ($prefix) {
            $package = $prefix.'/'.$package;
            $path = rtrim($path, '/');

            if (! File::exists($package)) {
                File::link($path, $package);
                $this->line("The [$package] directory has been linked.");
            }
        });

        $this->info('Links have been created.');
    }
}
