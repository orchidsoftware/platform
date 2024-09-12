<?php

declare(strict_types=1);

namespace Orchid\Platform\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orchid:publish')]
class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orchid:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Orchid resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag'   => 'orchid-assets',
            '--force' => true,
        ]);
    }
}
