<?php


namespace Orchid\Platform\Commands;


use Illuminate\Console\Command;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Symfony\Component\Console\Helper\ProgressBar;

class AssetsCommand extends Command
{
    /**
     * @var ProgressBar
     */
    protected $progressBar;

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
        $this->progressBar = $this->output->createProgressBar(2);
        $this->info("Publishing assets..");
        $this
            ->executeCommand("vendor:publish", [
                "--provider" => FoundationServiceProvider::class,
                "--tag"      => 'orchid-assets',
                "--force"    => true
            ])
            ->executeCommand("preset", [
                'type'    => 'orchid'
            ]);
        $this->warn('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        $this->info("Assets published successfully");

    }

    /**
     * @param string $command
     * @param array $parameters
     *
     * @return $this
     */
    private function executeCommand(string $command, array $parameters = []): self
    {
        if (! $this->progressBar->getProgress()) {
            $this->progressBar->start();
            $this->info(' ');
        }

        $result = $this->call($command, $parameters);
        if ($result) {
            $parameters = http_build_query($parameters, '', ' ');
            $parameters = str_replace('%5C', '/', $parameters);
            $this->alert("An error has occurred. The '{$command} {$parameters}' command was not executed");
        }

        $this->progressBar->advance();
        $this->line('');

        // Visually slow down the installation process so that the user can read what's happening
        usleep(350000);

        return $this;
    }

}