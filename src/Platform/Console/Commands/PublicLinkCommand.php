<?php

declare(strict_types=1);

namespace Orchid\Platform\Console\Commands;

use Illuminate\Console\Command;

class PublicLinkCommand extends Command
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
    protected $description = 'Create a symbolic link from "vendor/orchid" to "public/orchid"';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (file_exists(public_path('orchid'))) {
            return $this->error('The "public/orchid" directory already exists.');
        }

        $this->laravel->make('files')->link(realpath(DASHBOARD_PATH.'/public/'), public_path('orchid'));

        $this->info('The [public/orchid] directory has been linked.');
    }
}
