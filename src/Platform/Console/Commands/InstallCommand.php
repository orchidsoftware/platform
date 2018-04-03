<?php

declare(strict_types=1);

namespace Orchid\Platform\Platform\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Providers\FoundationServiceProvider;

class InstallCommand extends Command
{
    /**
     * @var
     */
    protected $progressBar;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'orchid:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish files for ORCHID and install package"';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->progressBar = $this->output->createProgressBar(7);
        $this->info(" ORCHID installation started. Please wait...");

        $this
            ->executeCommand('vendor:publish', [
                '--provider' => FoundationServiceProvider::class
            ])->executeCommand('vendor:publish', [
                '--all' => true
            ])
            ->executeCommand('migrate')
            ->executeCommand('storage:link')
            ->executeCommand('orchid:link');


        $this->changingUserModel();
        $this->progressBar->finish();

        $this->line(" Completed!");
        $this->info(" ORCHID installation finished.");
    }

    /**
     * @param string $command
     * @param array  $parametrs
     *
     * @return $this
     */
    private function executeCommand(string $command, $parametrs = [])
    {
        if(!$this->progressBar->getProgress()){
            $this->progressBar->start();
            echo ' ';
        }

        $result = $this->call($command, $parametrs);
        if ($result) {
            $parametrs = http_build_query($parametrs, '', ' ');
            $parametrs = str_replace("%5C", "/", $parametrs);
            $this->alert("An error has occurred. The '{$command} {$parametrs}' command was not executed");
        }

        $this->progressBar->advance();
        echo ' ';

        return $this;
    }

    /**
     *
     */
    private function changingUserModel()
    {
        $this->progressBar->advance();

        $this->info(' Attempting to set ORCHID User model as parent to App\User');

        if (!file_exists(app_path('User.php'))) {
            $this->warn('Unable to locate "app/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.  Change "extends Authenticatable" to "extends \Orchid\Platform\Core\Models\User" in your User model');
            return;
        }

        $str = file_get_contents(app_path('User.php'));

        if ($str !== false) {
            $str = str_replace('extends Authenticatable', "extends \Orchid\Platform\Core\Models\User", $str);
            file_put_contents(app_path('User.php'), $str);
        }

    }

}