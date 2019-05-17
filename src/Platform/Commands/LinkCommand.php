<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Orchid\Platform\Dashboard;
use Illuminate\Console\Command;

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
        $prefix = public_path('/resources');

        if (file_exists($prefix)) {
            $this->error("The [$prefix] directory already exists.");

            return;
        }

        $dashboard->getPublicDirectory()->each(function ($path, $package) use ($prefix) {
            $package = $prefix.'/'.$package;
            $path = rtrim($path, '/');

            $this->getLaravel()->make('files')->makeDirectory($prefix, 0755, true);
            $this->getLaravel()->make('files')->link($path, $package);
        });

        $this->info("The [$prefix] directory has been linked.");
    }
}
