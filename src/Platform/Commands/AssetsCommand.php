<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Providers\FoundationServiceProvider;

class AssetsCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish assets for ORCHID';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => FoundationServiceProvider::class,
            '--tag'      => 'orchid-assets',
            '--force'    => true,
        ]);

        $this->call('preset', [
            'type' => 'orchid',
        ]);

        $this->warn('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        $this->info('Assets published successfully');
    }
}
